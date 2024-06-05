<x-app-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="neutralize rounded-3 col-md-4 p-3">
                <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" href="{{ route('register') }}" >Register</a>
                    </li>
                </ul>

                <hr />

                <div class="tab-content">
                    @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <h3 class="mb-3 text-center">{{ __('Register') }}:</h3>

                            <!-- Name input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" id="name" name="name" class="form-control" />
                                <label class="form-label" for="name">{{ __('Name') }}</label>
                            </div>

                            <!-- Email input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="email" id="email" name="email" class="form-control" />
                                <label class="form-label" for="email">{{ __('E-mail address') }}</label>
                            </div>

                            <!-- Password input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="password" name="password" class="form-control" />
                                <label class="form-label" for="password">{{ __('Password') }}</label>
                            </div>

                            <!-- Password Confirmation -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" />
                                <label class="form-label" for="password_confirmation">{{ __('Password confirmation') }}</label>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <!-- Submit button -->
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                            </div>

                            <!-- Register buttons -->
                            <div class="text-center">
                                <p>Already a member? <a href="{{ route('login') }}">{{ __('Login') }}</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
