<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Index Todo Page") }}
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-0"> {{-- Mengurangi margin bawah dari mb-12 menjadi mb-0 --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <x-create-button href="{{ route('todo.create') }}" />
                    </div>

                    @if (session('success'))
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 5000)"
                            class="text-sm text-green-600 dark:text-green-400"
                        >
                            {{ session('success') }}
                        </p>
                    @endif

                    @if (session('danger'))
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 5000)"
                            class="text-sm text-red-600 dark:text-red-400"
                        >
                            {{ session('danger') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-0"> {{-- Menghilangkan margin bawah di sini --}}
                <table class="min-w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left">Title</th>
                            <th scope="col" class="px-6 py-3 text-left">Status</th>
                            <th scope="col" class="px-6 py-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($todos as $data)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                                    <a href="{{ route('todo.edit', $data) }}" class="hover:underline text-xs">
                                        {{ $data->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    @if (!$data->is_complete)
                                        <span class="inline-flex items-center bg-red-100 text-red-800 text-sm font-medium px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">
                                            On Going
                                        </span>
                                    @else
                                        <span class="inline-flex items-center bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">
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
                                                <button type="submit" class="text-green-600 dark:text-green-400 text-xs hover:underline">
                                                    Complete
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('todo.uncomplete', $data) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-blue-600 dark:text-blue-400 text-xs hover:underline">
                                                    Uncomplete
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('todo.destroy', $data) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 text-xs hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No data available
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($todosCompleted > 1)
        <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
            <form action="{{ route('todo.deleteallcompleted') }}" method="POST">
                @csrf
                @method('DELETE')
                <x-primary-button>
                    Delete All Completed Task
                </x-primary-button>
            </form>
        </div>
    @endif
</x-app-layout>
