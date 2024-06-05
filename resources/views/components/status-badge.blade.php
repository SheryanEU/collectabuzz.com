@props(['status'])

@switch($status)
    @case('sub legendary')
        @php $class = 'text-bg-success'; @endphp
        @break

    @case('legendary')
        @php $class = 'text-bg-danger'; @endphp
        @break

    @case('mythical')
        @php $class = 'text-bg-warning'; @endphp
        @break

    @default
        @php $class = 'text-bg-primary'; @endphp
@endswitch

<span class="badge {{ $class }}">{{ ucfirst($status) }}</span>
