@props(['value', 'for'])

<label>
    {{ $value ?? $slot }}
</label>
