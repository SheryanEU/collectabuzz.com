@props(['status'])

@switch($status)
    @case('grass')
        @php $class = 'btn-success'; @endphp
        @break

    @case('fire')
        @php $class = 'btn-danger'; @endphp
        @break

    @case('electric')
        @php $class = 'btn-warning'; @endphp
        @break

    @default
        @php $class = 'btn-primary'; @endphp
@endswitch

<span class="btn btn-sm {{ $class }}">{{ ucfirst($status) }}</span>
