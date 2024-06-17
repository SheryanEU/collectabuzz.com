<x-app-layout>
    <div class="container">
        @foreach($cards as $card)
            <img loading="lazy"
                 src="{{ asset($card->image) }}"
                 class="figure-img img-fluid fixed-image-size mx-auto d-block p-3 beautiful-image"
                 alt="Image of: {{ $card->pokemon->name }}">
            <small>{{ $card->pokemon->number }}</small> <em>{{ $card->rarity }}</em>
            <h5>{{ $card->pokemon->name }}</h5>
            <code>{!! $card->card_id !!}</code>
        @endforeach
    </div>
</x-app-layout>
