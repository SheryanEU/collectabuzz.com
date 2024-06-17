<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Contracts\View\View;

class CardController extends Controller
{
    public function browse(): View
    {
        $cards = Card::withRelations()->get();

        return view('card.browse', compact('cards'));
    }
}
