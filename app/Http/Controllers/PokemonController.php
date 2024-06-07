<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Pokemon;
use App\Services\PokemonTcgApiService as PokemonApi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\View\View;

class PokemonController extends Controller
{
    private PokemonApi $pokemonService;

    public function __construct() {
        $this->pokemonService = new PokemonApi('56b25750-0602-48aa-886f-241fb6d24d13');
    }

    public function browse(): View
    {
        $pokemons = Pokemon::all()->groupBy('generation');

        return view('pokedex.browse', compact('pokemons'));
    }

    public function api()
    {
        try {
//            $sets = $this->pokemonService->getSet()->all();
//            $sets = $this->pokemonService->getCard()->all();
//            $sets = $this->pokemonService->getCard()->find('3/165');
            $name = "ivysaur";
            $set = 'sv3pt5';
            $query = [
                'q' => 'name:' . $name . ' set.id:' . $set
            ];
            $sets = $this->pokemonService->getCard()->search($query);
            dd($sets);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
