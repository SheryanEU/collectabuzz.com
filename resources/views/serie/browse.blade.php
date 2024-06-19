<x-app-layout>
    <div class="container">
        <div class="row">
            @foreach($series as $serie)
                <a
                    rel="preload"
                    class="col-sm-12 col-md-6 col-lg-3 d-flex align-items-stretch mb-4"
                    href="{{ route('serie.set', $serie->slug) }}"
                    >
                        @include('serie.parts.serie-card', ['serie' => $serie])
                </a>
          @endforeach
        </div>
    </div>
</x-app-layout>
