@props(['status'])

@php $class = null; @endphp

@switch($status)
    @case('sub legendary')
        @php $class = 'sub-legendary'; @endphp
        @break

    @default
        @if($status !== 'normal')
            @php $class = $status @endphp
        @endif
@endswitch

@if ($class)
    <span class="status-badge status-{{ $class }}">{{ ucfirst($status) }}</span>
@endif
