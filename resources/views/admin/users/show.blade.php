<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <x-admin.update-profile-information-form :user="$user" />

            <x-section-border />

            <div class="mt-10 sm:mt-0">
                <x-admin.update-password-form :user="$user" />
            </div>

            <x-section-border />

            <div class="mt-10 sm:mt-0">
                <x-admin.sessions-form :user="$user" :sessions="$sessions" />
            </div>

            <x-section-border />

            <div class="mt-10 sm:mt-0">
                <x-admin.delete-user-form :user="$user" />
            </div>
        </div>
    </div>
</x-app-layout>
