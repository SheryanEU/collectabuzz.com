<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Contracts\View\View;

class SerieController extends Controller
{
    public function browse(): View
    {
        $series = Serie::orderBy('id', 'desc')->get();

        return view('serie.browse', compact('series'));
    }

    public function read(Serie $serie): View
    {
        $serie->load('sets');

        return view('serie.read', compact('serie'));
    }
}
