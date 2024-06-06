<x-app-layout>
    <div class="container">
        @foreach($pokemons as $gen => $pokemonGroup)
            <div class="row">
                <h2 class="col-12" id="generation-{{ $gen }}">Generation {{ $gen }}</h2>
                @foreach($pokemonGroup as $pokemon)
                    <div class="col-sm-6 col-md-4 p-2">
                        @include('pokedex.partials.pokemon-card', ['pokemon' => $pokemon])
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</x-app-layout>
