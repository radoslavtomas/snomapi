<x-admin.action-section>
    <x-slot name="title">
        {{ __('Delete Account') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Permanently delete user\'s account.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once user\'s account is deleted, all of its resources and data will be permanently deleted. Before deleting the account, please download any data or information that you wish to retain.') }}
        </div>

        <div class="mt-5">
            <x-danger-button>
                {{ __('Delete Account') }}
            </x-danger-button>
        </div>
    </x-slot>
</x-admin.action-section>
