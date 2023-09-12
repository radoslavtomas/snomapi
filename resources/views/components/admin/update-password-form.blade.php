<x-admin.form-section submit="{{ route('admin.users.update_password', $user->id) }}" method="PUT">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure user\'s account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('New Password') }}" />
            <x-input id="password" type="password" name="password" class="mt-1 block w-full" />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-input id="password_confirmation" type="password" name="password_confirmation" class="mt-1 block w-full" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>

    @if (session('status.password'))
        <x-slot name="messages">
            <x-admin.action-message class="bg-green-900">
                {{ session('status.password') }}
            </x-admin.action-message>
        </x-slot>
    @endif
</x-admin.form-section>
