<x-app-layout>
    <div class="container">
        @foreach($sets as $serieName => $setGroup)
            <h3 class="text-center mb-3">{{ $serieName }}</h3>
            <div class="row">
                @foreach($setGroup as $set)
                    <a
                        class="col-sm-12 col-md-6 col-xl-4 d-flex align-items-stretch mb-4"
                        href="{{ route('set.read', [$set->slug]) }}">
                            @include('set.parts.set-card', ['set' => $set])
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>
</x-app-layout>
