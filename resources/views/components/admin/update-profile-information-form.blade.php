<x-admin.form-section submit="{{ route('admin.users.update', $user->id) }}" method="PUT">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update user\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" name="name" class="mt-1 block w-full" required value="{{ old('name', $user['name']) }}" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" name="email" class="mt-1 block w-full" required value="{{ old('email', $user['email']) }}"/>
            <x-input-error for="email" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>

    @if (session('status.profile'))
    <x-slot name="messages">
        <x-admin.action-message class="bg-green-900">
            {{ session('status.profile') }}
        </x-admin.action-message>
    </x-slot>
    @endif
</x-admin.form-section>
