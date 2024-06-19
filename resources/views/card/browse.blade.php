<x-app-layout>
    <div class="container">
        <div class="row">
            @foreach($cardsGroupedBySeriesAndSets as $serieName => $serie)
                <h2>{{ $serieName }}</h2>
                @foreach($serie as $setName => $set)
                    <h3 class="h4">{{ $setName }} ({{ $set->count() }})</h3>
                    @foreach($set as $card)
                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 p-2">
                            @include('card.parts.card', ['card' => $card])
                        </div>
                    @endforeach
                @endforeach
            @endforeach
        </div>
    </div>
</x-app-layout>
