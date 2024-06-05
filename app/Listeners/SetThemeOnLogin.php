<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetThemeOnLogin
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $theme = session('theme', 'dark');
        $color = $theme === 'dark' ? 'white' : 'black';

        session(['theme' => $theme]);
        session(['color' => $color]);
    }
}
