<x-app-layout>
    <div class="container">
        <h3 class="text-center mb-3">{{ $set->name }}</h3>
        <div class="row">
            @if($set->cards)
                @foreach($set->cards as $card)
                    <div class="col-sm-12 col-md-6 col-xl-4 d-flex align-items-stretch mb-4">
                        @include('set.parts.set-card', ['card' => $card])
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
