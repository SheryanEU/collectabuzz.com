<x-app-layout>
    <div class="container">
        <h3 class="text-center mb-3">{{ $serie->name }}</h3>
        <div class="row">
            @foreach($serie->sets as $set)
                <a
                    class="col-12 d-flex align-items-stretch mb-4"
                    href="{{ route('serie.set.read', [$serie->slug, $set->slug]) }}">
                    @include('set.parts.set-card', ['set' => $set])
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
