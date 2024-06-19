<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Contracts\View\View;

class CardController extends Controller
{
    public function browse(): View
    {
        $cardsGroupedBySeriesAndSets = Card::withRelations()->get()->groupBy(function ($card) {
            // Group by series name via set
            return $card->set->serie->name;
        })->map(function ($seriesGroup) {
            // For each series group, group by set name
            return $seriesGroup->groupBy(function ($card) {
                return $card->set->name;
            });
        });

        return view('card.browse', compact('cardsGroupedBySeriesAndSets'));
    }
}
