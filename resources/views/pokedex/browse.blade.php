<x-app-layout>
    <div class="row">
        @foreach($pokemons as $pokemon)
            <div class="col-sm-6 col-md-4 p-2">
                @include('pokedex.partials.pokemon-card', $pokemon)
            </div>
        @endforeach
    </div>
</x-app-layout>
