<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="container mx-auto">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 text-white">
            @foreach($users as $user)
                <h1>{{$user->name}} - {{ $user->email }}</h1>
            @endforeach

                <div class="mt-10">
                    {{ $users->links() }}
                </div>
        </div>
    </div>
</x-app-layout>
