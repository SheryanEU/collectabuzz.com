<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Dto\Attack;
use App\Dto\Card;
use App\Dto\Set;
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

        $this->pokemonService = new PokemonApi(config('pokemontcg.api_key'));
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            //$sets = SetModel::orderBy('id', 'desc')->get();
            $sets = SetModel::orderBy('id', 'desc')->skip(4)->take(1)->get();
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

        if (array_key_exists('nationalPokedexNumbers', $card)) {
            $pokemon = Pokemon::where('number', $card['nationalPokedexNumbers'][0])->orWhere('name', 'like', '%' . $card['name'] . '%')->first();
        } else {
            $pokemon = Pokemon::where('name', 'like', '%' . $card['name'] . '%')->first();
        }

        if ($card['supertype'] === 'Pokémon') {
            if (!$pokemon) {
                Log::error('Pokemon not found: ' . json_encode($card));
                die();
            }

            $name = $pokemon->name;
        } else {
            $name = $card['name'];
        }

        $this->info('Related pokemon found: ' . $name);

        foreach ($variants as $variant => $details) {
            $this->info('Processing card: ' . $name . ' - ' . $variant);

            $types = array_map(fn($type) => new Type($type), $card['types'] ?? []);
            $subtypes = array_map(fn($subtype) => new Subtype($subtype), $card['subtypes'] ?? []);
            $attacks = array_map(fn($attack) => new Attack(
                $attack['name'],
                $attack['convertedEnergyCost'],
                $attack['damage'],
                $attack['text'],
                array_map(fn($cost) => new Type($cost), $attack['cost'])
            ), $card['attacks'] ?? []);

            $weaknesses = array_map(fn($weakness) => new Weakness(
                new Type($weakness['type']),
                (int)ltrim($weakness['value'], '×'),
            ), $card['weaknesses'] ?? []);

            $cardDto = $this->generateCardDto(
                $card,
                $pokemon ?? null,
                $name,
                $setDto,
                $types,
                $subtypes,
                $attacks,
                $weaknesses
            );

            $created = $this->cardService->create($cardDto);
            $this->info('Processed card: ' . $created->name . ' - ' . $created->variant);
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

    /**
     * @param array $card
     * @param Pokemon|null $pokemon
     * @param string $name
     * @param SetDto $set
     * @param Type[] $types
     * @param Subtype[] $subtypes
     * @param Attack[] $attacks
     * @param Weakness[] $weaknesses
     *
     * @return Card
     *
     * @throws ValidationException
     */
    private function generateCardDto(
        array $card,
        ?Pokemon $pokemon,
        string $name,
        Set $set,
        array $types,
        array $subtypes,
        array $attacks,
        array $weaknesses
    ): Card
    {
        return new Card(
            $set,
            $card['id'],
            $pokemon->id ?? null,
            $name,
            $details['variant'],
            $card['supertype'],
            $card['hp'] ?? null,
            $card['rarity'] ?? null,
            $card['artist'] ?? null,
            $card['images']['small'] ?? null,
            $card['images']['large'] ?? null,
            $types,
            $subtypes,
            $attacks,
            $weaknesses
        );
    }
}
