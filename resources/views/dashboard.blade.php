<x-app-layout>
    <div class="row">
        <div class="col-md pb-3">
            <div class="card text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">
                <div class="card-body">
                    <h2 class="card-title mb-0 pb-0  fs-3">
                    {{ __('Welcome') }} <span class="fst-italic">{{ Auth::user()->name }}</span>,
                    </h2>
                    <small class="fst-italic fw-light">Account created on: {{ Auth::user()->created_at }}</small>
                    <p>

                    </p>
                </div>
            </div>
        </div>
        <div class="col-md pb-3">
            <div class="card text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">
                <div class="card-body">
                    <h3 class="card-title mb-0 pb-0">
                        {{ __('Account value') }},
                    </h3>
                    <small class="fst-italic fw-light">
                        {{ __('Account value is based on the cards you marked as owned.') }}
                    </small>
                    <p>
                        &euro; 12.345,67
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
