<?php

namespace App\Http\Controllers;

use App\Models\Serie as SerieModel;
use App\Models\Set;
use Illuminate\Contracts\View\View;

class SetController extends Controller
{
    public function browse(): View
    {
        $sets = Set::select('id', 'name', 'slug', 'logo_src', 'release_date', 'serie_id')
            ->with('serie:id,name')
            ->orderBy('release_date', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return $item->serie->name;
            });

        return view('set.browse', compact('sets'));
    }

    public function read(SerieModel $serie, Set $set): View
    {
        $set->load(['serie', 'cards']);

        return view('set.read', compact('set'));
    }
}
