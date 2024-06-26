<div class="card text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }} w-100">
    <div class="card-body d-flex flex-column">
        <figure class="figure">
            @if($set->logo_src)
                <img loading="lazy"
                     src="{{ asset($set->logo_src) }}"
                     class="figure-img img-fluid fixed-image-size mx-auto d-block p-3 beautiful-image"
                     alt="Image of: {{ $set->name }}">
            @endif
            <figcaption class="figure-caption text-center text-{{ session('color', 'white') }}">
                {{ $set->name }}
            </figcaption>
        </figure>
    </div>
</div>
