<?php

namespace App\Http\Controllers;

use App\Models\Serie as SerieModel;
use App\Models\Set;
use Illuminate\Contracts\View\View;

class SetController extends Controller
{
    public function browse(): View
    {
        $sets = Set::with('serie')
            ->orderBy('release_date', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return $item->serie->name;
            });

        return view('set.browse', compact('sets'));
    }

    public function read(SerieModel $serie = null, Set $set): View
    {
        if ($serie) {
            $set->load('serie');
        }

        return view('set.read', compact('set'));
    }
}
