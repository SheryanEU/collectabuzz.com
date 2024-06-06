<x-app-layout>
    <div class="container">
        <section class="text-center py-5">
            <h1 class="display-4">Register Your Pokémon Cards</h1>
            <p class="lead">Keep track of your Pokémon card collection and get value estimations in real-time.</p>
        </section>
    </div>

    <div class="container">
        <section class="row justify-content-center py-5 mx-0">
            <div class="col-md-8">
                <div class="card text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">
                    <div class="card-body">
                        <h2 class="h5">Features</h2>
                        <ul class="list-group list-group-{{ session('theme', 'dark') }}">
                            <li class="list-group-item text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">Add and manage your Pokémon cards easily.</li>
                            <li class="list-group-item text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">Get real-time value estimations of your collection.</li>
                            <li class="list-group-item text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">Track the rarity and condition of each card.</li>
                            <li class="list-group-item text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">Organize your collection by set, type, and more.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="container-fluid">
        <section class="text-center py-5" style="background-color: #374151;">
            <div class="container">
                <h2 class="h4">Ready to Organize Your Pokémon Collection?</h2>
                <p>Sign up today and start managing your collection like a pro!</p>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">{{ __('Register your account!') }}</a>
            </div>
        </section>
    </div>

    <div class="container">
        <section class="row justify-content-center py-5 mx-0">
            <div class="col-md-8">
                <div class="card text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">
                    <div class="card-body">
                        <h2 class="h5">How It Works</h2>
                        <p>Registering your collection is simple and free. Follow these steps to get started:</p>
                        <ol class="list-group text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">
                            <li class="list-group-item text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">
                                <strong>Create an Account:</strong> Sign up quickly with your email and a password.
                            </li>
                            <li class="list-group-item text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">
                                <strong>Add Your Cards:</strong> Enter details about each card, including set, condition, and more.
                            </li>
                            <li class="list-group-item text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">
                                <strong>Get Insights:</strong> View your collection’s total value and track changes over time.
                            </li>
                            <li class="list-group-item text-{{ session('color', 'white') }} bg-{{ session('theme', 'dark') }}">
                                <strong>Share Your Collection:</strong> Easily share your collection with friends or on social media.
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
