<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Services\PokemonTcgApi\PokemonTcgApiService as PokemonApi;
use Illuminate\Contracts\View\View;

class PokemonController extends Controller
{
    private PokemonApi $pokemonService;

    public function __construct() {
        $this->pokemonService = new PokemonApi('56b25750-0602-48aa-886f-241fb6d24d13');
    }

    public function browse(): View
    {
        $pokemons = Pokemon::select(
            'number',
            'name',
            'generation',
            'status',
            'primary_type',
            'secondary_type'
        )->get()->groupBy('generation');

        return view('pokedex.browse', compact('pokemons'));
    }

    public function api()
    {
        try {
            $sets = $this->pokemonService->getSet()->all();
            $cards = $this->pokemonService->getCard()->all();
            $find = $this->pokemonService->getCard()->find('sv3pt5-2');
            $name = "ivysaur";
            $set = 'sv3pt5';
            $query = [
                'q' => 'name:' . $name . ' set.id:' . $set
            ];
            $search = $this->pokemonService->getCard()->search($query);
            dd($find, $search, $sets, $cards);
        } catch (\Exception $e) {
//            dd($e->getMessage());
//            dd($e->getMessage());
        }
    }
}
