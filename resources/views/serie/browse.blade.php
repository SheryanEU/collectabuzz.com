<x-app-layout>
    <div class="container">
        <div class="row">
            @foreach($series as $serie)
                <a
                    rel="preload"
                    class="col-12 d-flex align-items-stretch mb-4"
                    @if($serie->hexadecimalcolor) style="background-color: {{ $serie->hexadecimalcolor }}" @endif
                    href="{{ route('serie.set', $serie->slug) }}">
                        @include('serie.parts.serie-card', ['serie' => $serie])
                </a>
          @endforeach
        </div>
    </div>
</x-app-layout>
