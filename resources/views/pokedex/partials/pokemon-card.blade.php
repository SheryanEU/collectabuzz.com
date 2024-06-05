<div class="card text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">
    <div class="card-header">
        <x-status-badge :status="$pokemon->status" />
    </div>
    <div class="card-body">
        <h5 class="card-title">{{ $pokemon->name }}</h5>
        <h6 class="card-subtitle mb-2">
            {{ __('Gen') }}: {{ $pokemon->generation }}
            @if($pokemon->primary_type)
                {{ __('Type') }}: <x-type-badge :status="$pokemon->primary_type" />
                @if($pokemon->secondary_type)
                    <x-type-badge :status="$pokemon->secondary_type" />
                @endif
            @endif
        </h6>
    </div>
</div>
