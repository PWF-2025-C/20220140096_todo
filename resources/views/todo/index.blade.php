<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-0">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-xl text-gray-900 dark:text-gray-100 flex justify-between items-center">
                    <x-create-button href="{{ route('todo.create') }}" />

                    @if (session('success'))
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" class="text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </p>
                    @endif

                    @if (session('danger'))
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" class="text-sm text-red-600 dark:text-red-400">
                            {{ session('danger') }}
                        </p>
                    @endif
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-xs text-gray-700 dark:text-gray-400 uppercase">
                            <tr>
                                <th class="px-6 py-3">Title</th>
                                <th class="px-6 py-3">Category</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($todos as $data)
                                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-900 dark:even:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('todo.edit', $data) }}" class="hover:underline text-xs text-gray-900 dark:text-gray-100">
                                            {{ $data->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $data->category->title ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if (!$data->is_complete)
                                            <span class="inline-flex bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300 text-sm px-2.5 py-0.5 rounded-sm">
                                                On Going
                                            </span>
                                        @else
                                            <span class="inline-flex bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 text-sm px-2.5 py-0.5 rounded-sm">
                                                Completed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-3">
                                            @if (!$data->is_complete)
                                                <form action="{{ route('todo.complete', $data) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="text-green-600 dark:text-green-400 text-xs hover:underline">Complete</button>
                                                </form>
                                            @else
                                                <form action="{{ route('todo.uncomplete', $data) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="text-blue-600 dark:text-blue-400 text-xs hover:underline">Uncomplete</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('todo.destroy', $data) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 dark:text-red-400 text-xs hover:underline">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($todosCompleted > 1)
                    <div class="p-6">
                        <form action="{{ route('todo.deleteallcompleted') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-primary-button>Delete All Completed Task</x-primary-button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
