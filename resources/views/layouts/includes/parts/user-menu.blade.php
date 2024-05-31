<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ Auth::user()->name }}
    </a>
    <ul class="dropdown-menu dropdown-menu-{{ session('theme', 'dark') }}">
        <li>
            <a class="dropdown-item {{ Route::is('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
        </li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <form class="ms-3" id="theme-toggle-form" method="POST" action="/toggle-theme">
                @csrf
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="theme-toggle" {{ session('theme', 'dark') === 'dark' ? 'checked="checked"' : '' }}">
                    <label class="form-check-label" for="themeToggleSwitch">{{ session('theme', 'dark') }} Mode</label>
                </div>
            </form>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="dropdown-item cursor-pointer">{{ __('Log Out') }}</button>
            </form>
        </li>
    </ul>
</li>
