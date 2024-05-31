<div class="d-inline-flex justify-content-between">
    <x-dropdown-link class="btn btn-lg btn-success w-100 me-2 text-center" :href="route('login')">
        {{ __('Login') }}
    </x-dropdown-link>

    <x-dropdown-link class="btn btn-lg btn-info w-100 ms-2 text-center" :href="route('register')">
        {{ __('Register') }}
    </x-dropdown-link>
</div>
