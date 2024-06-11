<?php

namespace App\Console\Commands;

use App\Dto\Serie;
use App\Dto\Set;
use App\Models\Serie as SerieModel;
use App\Services\PokemonTcgApi\PokemonTcgApiService as PokemonApi;
use App\Services\Serie\Serie as SerieService;
use App\Services\Set\Set as SetService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class FetchTcgSeriesAndSets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:series-and-sets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed all Pokémon TCG series and sets.';

    private PokemonApi $pokemonService;

    /**
     * Create a new command instance.
     * @return void
     */
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
            $sets = $this->pokemonService->getSet()->all();
            $this->info('Fetched sets successfully.');

            if (!array_key_exists('data', $sets) || empty($sets['data'])){
                throw new \Exception('Empty sets data.');
            }

            foreach ($sets['data'] as $set) {
                $serie = $this->serieService->create(
                    new Serie(
                        null,
                        $set['series'],
                        null,
                        null,
                        null,
                        $set['images']['logo']
                    )
                );

                $serieModel = SerieModel::where('serie_id', $serie->serieId)
                    ->where('slug', $serie->slug)
                    ->firstOrFail();

                $this->info('Handle serie: ' . $serie->slug);

                $set = $this->setService->create(
                    new Set(
                        $serieModel->id,
                        $set['id'],
                        $set['name'],
                        null,
                        $set['ptcgoCode'] ?? null,
                        $set['printedTotal'],
                        $set['total'],
                        null,
                        $set['releaseDate'] ? Carbon::createFromFormat('Y/m/d', $set['releaseDate']) : null,
                        $set['images']['logo'],
                        $set['images']['symbol'],
                    )
                );
                $this->info('Handle set: ' . $set->slug);
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
