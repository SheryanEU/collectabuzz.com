<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Services\PokemonTcgApi\PokemonTcgApiService as PokemonApi;
use Illuminate\Contracts\View\View;

class PokemonController extends Controller
{
    private PokemonApi $pokemonService;

    public function __construct() {
        $this->pokemonService = new PokemonApi(config('pokemontcg.api_key'));
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
            //$sets = $this->pokemonService->getSet()->all();
            //$cards = $this->pokemonService->getCard()->all();
            //$find = $this->pokemonService->getSet()->find('sv6');
            $card = $this->pokemonService->getCard()->find('sv3pt5-1');
            $card1 = $this->pokemonService->getCard()->find('sv3pt5-207');
            $card2 = $this->pokemonService->getCard()->find('sv3pt5-195');
            $card3 = $this->pokemonService->getCard()->find('sv3pt5-165');
            $card4 = $this->pokemonService->getCard()->find('sv3pt5-155');
            $card5 = $this->pokemonService->getCard()->find('base2-1');
            $card6 = $this->pokemonService->getCard()->find('sv3pt5-199');
            $card7 = $this->pokemonService->getCard()->find('sv3pt5-174');
            $name = "ivysaur";
            $set = 'sv3pt5';
            $query = [
                'q' => 'name:' . $name . ' set.id:' . $set
            ];
            //$search = $this->pokemonService->getCard()->search($query);
            //dd($find, $search, $card);
//            dd($card);
            dd($card, $card1, $card2, $card3, $card4, $card5, $card6, $card7);
        } catch (\Exception $e) {
//            dd($e->getMessage());
//            dd($e->getMessage());
        }
    }
}
