<div class="card text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">
    <div class="card-body">
        <h2 class="card-title">
            {{ __('Theme settings') }}
        </h2>

        <p>
            {{ __('Choose a default theme. (You can always change this later)') }}
        </p>

        <form id="theme-toggle-form" method="POST" action="/toggle-theme">
            @csrf
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="theme-toggle" {{ session('theme', 'dark') === 'dark' ? 'checked="checked"' : '' }}">
                <label class="form-check-label" for="themeToggleSwitch">{{ ucfirst(session('theme', 'dark')) }} mode</label>
            </div>
        </form>
    </div>
</div>
