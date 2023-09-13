<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="container mx-auto">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 text-white">
            @if (session('status.index'))
                <x-admin.action-message class="bg-green-900 mb-8">
                    {{ session('status.index') }}
                </x-admin.action-message>
            @endif

            <div class="mb-8">
                <a href="{{ route('admin.users.create') }}" class="py-2 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-green-700 text-white hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                    Create new user
                    <svg class="w-4 h-auto" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"></path>
                    </svg>
                </a>
            </div>

            <div class="border border-slate-600 rounded overflow-hidden">
                <table class="table-auto min-w-full border-collapse divide-y divide-slate-600">
                    <thead class="text-left rounded">
                    <tr class="divide-x divide-slate-600">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Is Admin</th>
                        <th class="px-4 py-2">Created At</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-slate-600">
                    @foreach($users as $user)
                        <tr class="divide-x divide-slate-600">
                            <td class="px-4 py-2">{{$user->id}}</td>
                            <td class="px-4 py-2">{{$user->name}}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{$user->is_admin ? 'Yes' : 'No' }}</td>
                            <td class="px-4 py-2">{{$user->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-center">
                                @if (auth()->id() === $user->id)
                                    <a href="{{ route('profile.show') }}" class="py-1 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-gray-500 text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                                        See profile
                                    </a>
                                @else
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="py-1 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-700 text-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                                        Manage
                                        <svg class="w-2.5 h-auto" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path>
                                        </svg>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-10">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
