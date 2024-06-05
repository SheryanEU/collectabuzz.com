<x-app-layout>
    <div class="row">
        <div class="col-md pb-3">
            <div class="max-w-lg">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="col-md pb-3">
            <div class="max-w-lg">
                @include('profile.partials.update-theme-form')
            </div>
        </div>

        <div class="col-md pb-3">
            <div class="max-w-lg">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="col-md pb-3">
            <div class="max-w-lg">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
