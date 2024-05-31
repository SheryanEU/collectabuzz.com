@props(['href'])

@php
    $active = Request::is(trim($href, '/')) ? 'active' : '';
@endphp

<a {{ $attributes->merge(['class' => 'nav-link ' . $active]) }} href="{{ $href }}">
    {{ $slot }}
</a>
