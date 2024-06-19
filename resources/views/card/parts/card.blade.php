<div class="card text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }} w-100">
    <div class="card-header position-relative">
        <div class="d-flex justify-content-between align-items-center">
            <p class="mb-0">
                @if($card->pokemon_id)
                    <small class="text-{{ session('color', 'white') }}-50 me-1">#{{ str_pad($card->pokemon_id, 4, '0', STR_PAD_LEFT) }}</small>
                @endif
                <span class="h5 capitalize">{{ $card->name }}</span></p>
            @if($card->hp)
                <p class="mb-0 text-{{ session('color', 'white') }}-50"><small>HP</small> {{ $card->hp }}</p>
            @endif
        </div>
        <div class="badge-container position-absolute start-0 end-0 mx-3">
            <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="badge bg-secondary p-2 font-monospace text-uppercase fst-italic">
                                        {{ $card->subtype ?? 'Basic' }}
                                    </span>
                <span class="badge bg-secondary p-2 capitalize">{{ $card->rarity }}</span>
            </div>
        </div>
    </div>
    <div class="card-body mt-0">
        <figure class="figure w-100">
            <img loading="lazy"
                 src="{{ asset($card->thumbnail) }}"
                 class="d-block figure-img mx-auto img-fluid rounded"
                 alt="Image of: {{ $card->name }}">
            <figcaption class="figure-caption text-center text-{{ session('color', 'white') }}">
                <small>id: <span>{{ $card->card_id }}</span> - A caption for the above image.</small>
            </figcaption>
        </figure>
    </div>
</div>
