<x-app-layout>
    <div class="container">
        @foreach($sets as $serieName => $setGroup)
            <h3 class="text-center mb-3">{{ $serieName }}</h3>
            <div class="row">
                @foreach($setGroup as $set)
                    <a
                        class="col-12 d-flex align-items-stretch mb-4"
                        href="{{ route('serie.set', $serie->slug) }}">
                            @include('set.parts.set-card', ['set' => $set])
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</x-app-layout>
