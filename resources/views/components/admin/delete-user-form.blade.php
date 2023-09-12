<x-admin.form-section submit="{{ route('admin.users.destroy', $user->id) }}" method="DELETE" id="delete_user">
    <x-slot name="title">
        {{ __('Delete Account') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Permanently delete user\'s account.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once user\'s account is deleted, all of its resources and data will be permanently deleted. Before deleting the account, please download any data or information that you wish to retain.') }}
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-danger-button onclick="confirmDeleteUser()">
            {{ __('Delete Account') }}
        </x-danger-button>
    </x-slot>
</x-admin.form-section>
