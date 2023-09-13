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

        <!-- Admin -->
        <div class="col-span-6 sm:col-span-4">
            <div class="flex">
            <input
                type="checkbox"
                id="is_admin"
                name="is_admin"
                {{ $user['is_admin'] ? 'checked' : '' }}
                class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
            <x-label for="is_admin" value="Is admin" class="text-sm text-gray-500 ml-3 dark:text-gray-400" />
        </div>

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
