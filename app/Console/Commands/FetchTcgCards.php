<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Dto\Attack;
use App\Dto\Card;
use App\Dto\Set as SetDto;
use App\Dto\Subtype;
use App\Dto\Type;
use App\Dto\Weakness;
use App\Models\Pokemon;
use App\Models\Set as SetModel;
use App\Services\Card\Card as CardService;
use App\Services\PokemonTcgApi\PokemonTcgApiService as PokemonApi;
use App\Services\Serie\Serie as SerieService;
use App\Services\Set\Set as SetService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class FetchTcgCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:cards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed all Pokémon TCG cards with variants.';

    private PokemonApi $pokemonService;

    public function __construct(
        public CardService $cardService,
        public SerieService $serieService,
        public SetService $setService,
    )
    {
        parent::__construct();

        $this->pokemonService = new PokemonApi('56b25750-0602-48aa-886f-241fb6d24d13');
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $sets = SetModel::all();

            if ($sets->isEmpty()) {
                $this->error('No sets found!');
                $this->error('Aborting...');
                die();
            }

            $this->info('Fetched sets successfully.');

            foreach ($sets as $set) {
                $setDto = $set->toDto();
                $this->info('Processing set: ' . $set->name);

                $cards = $this->pokemonService->getCard()->search(['q' => 'set.id:' . $setDto->setId]);

                if (!array_key_exists('data', $cards) || empty($cards['data'])) {
                    $this->warn("No cards found for set: $setDto->name with setId: $setDto->setId");
                    Log::warning("Could not find cards for set with set_id: $setDto->setId");
                    continue;
                }

                foreach ($cards['data'] as $card) {
                    $this->processCard($card, $setDto);
                }
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * @throws ValidationException
     */
    private function processCard(array $card, SetDto $setDto)
    {
        $variants = $this->getCardVariants($card);
        $this->info('Processing card: ' . $card['name']);

        $pokemon = Pokemon::where('name', 'like', '%' . $card['name'] . '%')->firstOrFail()->toDto();

        $this->info('Related pokemon found: ' . $pokemon->name);

        foreach ($variants as $variant => $details) {
            $this->info('Processing card: ' . $pokemon->name . ' - ' . $variant);

            $types = array_map(fn($type) => new Type($type), $card['types']);
            $subtypes = array_map(fn($subtype) => new Subtype($subtype), $card['subtypes']);
            $attacks = array_map(fn($attack) => new Attack(
                $attack['name'],
                $attack['convertedEnergyCost'],
                $attack['damage'],
                $attack['text'],
                array_map(fn($cost) => new Type($cost), $attack['cost'])
            ), $card['attacks']);
            $weaknesses = array_map(fn($weakness) => new Weakness(
                new Type($weakness['type']),
                (int) ltrim($weakness['value'], '×'),
            ), $card['weaknesses']);

            $cardDto = new Card(
                $setDto,
                $card['id'],
                $pokemon,
                $details['variant'],
                $card['supertype'],
                $card['hp'],
                $card['rarity'],
                $card['artist'],
                $card['images'],
                $types,
                $subtypes,
                $attacks,
                $weaknesses
            );

            $created = $this->cardService->create($cardDto);
            $this->info('Processed card: ' . $created->pokemon->name . ' - ' . $created->variant);
        }
    }

    private function getCardVariants($card): array
    {
        $variants = [];
        if (isset($card['tcgplayer']['prices'])) {
            foreach ($card['tcgplayer']['prices'] as $variant => $priceDetails) {
                $variants[$variant] = [
                    'variant' => $variant,
                    'image' => $this->getVariantImage($card, $variant),
                ];
            }
        } else {
            $variants['normal'] = [
                'variant' => 'normal',
            ];
        }

        return $variants;
    }

    private function getVariantImage($card, $variant)
    {
        $image = $card['images']['large'] ?? $card['images']['small'];

        if ($variant === 'reverseHolofoil' && isset($card['images']['reverseHolofoil'])) {
            $image = $card['images']['reverseHolofoil'];
        } elseif ($variant === 'holofoil' && isset($card['images']['holofoil'])) {
            $image = $card['images']['holofoil'];
        }

        return $image;
    }
}
