<div class="card text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">
    <div class="card-header">
        <x-status-badge :status="$pokemon->status" />
        <img loading="lazy"
             src="{{ asset('storage/pokemon/placeholder.png') }}"
             alt="Image of: {{ $pokemon->name }}"
             class="img-fluid rounded-circle mx-auto d-block p-3 beautiful-image">
    </div>
    <div class="card-body">
        <small class="text-sm font-monospace fst-italic">#{{ str_pad($pokemon->number, 4, '0', STR_PAD_LEFT) }}</small>
        <h5 class="card-title">{{ $pokemon->name }}</h5>
        @if($pokemon->primary_type)
            <h6 class="card-subtitle mb-2">
                    {{ __('Type') }}: <x-type-badge :status="$pokemon->primary_type" />
                    @if($pokemon->secondary_type)
                        <x-type-badge :status="$pokemon->secondary_type" />
                    @endif
            </h6>
        @endif
    </div>
</div>
