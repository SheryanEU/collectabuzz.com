<?php

namespace App\Console\Commands;

use App\Models\Set as SetModel;
use App\Services\PokemonTcgApi\PokemonTcgApiService as PokemonApi;
use App\Services\Serie\Serie as SerieService;
use App\Services\Set\Set as SetService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
            $this->info('Fetched sets successfully.');

            foreach ($sets as $set) {
                $this->info('Processing set: ' . $set->name);

                $cards = $this->pokemonService->getCard()->search(['q' => 'set.id:' . $set->set_id]);

                if (!array_key_exists('data', $cards) || empty($cards['data'])) {
                    $this->warn('No cards found for set: ' . $set['id']);
                    Log::warning("Could not find cards for set with set_id: $set->set_id");
                    continue;
                }

                foreach ($cards['data'] as $card) {
                    $this->processCard($card, $set->set_id);
                }
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    private function processCard($card, $setId)
    {
        $variants = $this->getCardVariants($card);
        dd($card, $setId, $variants);
        foreach ($variants as $variant => $details) {
            $this->cardService->create(
                new Card(
                    $setId,
                    $card['id'] . '-' . $variant,
                    $card['name'],
                    $details['variant'],
                    $card['supertype'],
                    $card['subtypes'],
                    $card['hp'],
                    $card['types'],
                    $card['attacks'],
                    $card['weaknesses'],
                    $card['rarity'],
                    $card['artist'],
                    $details['image'],
                )
            );
            $this->info('Processed card: ' . $card['name'] . ' - ' . $variant);
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
                'image' => $card['images']['large'] ?? $card['images']['small'],
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
