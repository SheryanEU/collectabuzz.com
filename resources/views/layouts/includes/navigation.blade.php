<nav class="navbar navbar-{{ session('theme', 'dark') }} bg-{{ session('theme', 'dark') }} fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-{{ session('theme', 'dark') }}" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">{{ config('app.name') }}</h5>
                <button type="button" class="btn-close btn-close-{{ session('color', 'white') }}" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column justify-content-between">
                <form class="d-flex mb-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-success" type="submit">Search</button>
                </form>
                <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
                    @guest()
                        <li class="nav-item">
                            <x-nav-link :href="route('home')" :class="Route::is('home') ? 'active' : ''">
                                {{ __('Home') }}
                            </x-nav-link>
                        </li>
                    @endguest
                    @auth()
                        <li class="nav-item">
                            <x-nav-link :href="route('dashboard')" :class="Route::is('dashboard') ? 'active' : ''">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        </li>
                        <li class="nav-item">
                            <x-nav-link :href="route('pokedex')" :class="Route::is('dashboard') ? 'active' : ''">
                                {{ __('Pokedex') }}
                            </x-nav-link>
                        </li>
                        <li class="nav-item">
                            <x-nav-link :href="route('dashboard')" :class="Route::is('dashboard') ? 'active' : ''">
                                {{ __('Sets') }}
                            </x-nav-link>
                        </li>
                        @include('layouts.includes.parts.user-menu')
                    @endauth
                </ul>

                @guest()
                    <div class="navbar-nav justify-content-end flex-grow-1 p-3">
                        @include('layouts.includes.parts.guest-menu')
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

@section('scripts')
    <script>
        document.getElementById('theme-toggle').addEventListener('click', function () {
            fetch('/toggle-theme', {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}})
                .then(() => location.reload());
        });
    </script>
@endsection
