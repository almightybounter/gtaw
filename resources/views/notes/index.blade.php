<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Notes') }}
            </h2>
            <a href="{{ route('notes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create New Note
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('notes.index') }}" class="flex gap-4">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search notes by title or content..." 
                               class="flex-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('notes.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Notes List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($notes->count() > 0)
                        <div class="grid gap-4">
                            @foreach($notes as $note)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold mb-2">
                                                <a href="{{ route('notes.show', $note) }}" class="text-blue-600 hover:text-blue-800">
                                                    {{ $note->title }}
                                                </a>
                                            </h3>
                                            <p class="text-gray-600 dark:text-gray-400 mb-2">
                                                {{ Str::limit($note->content, 150) }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                Updated: {{ $note->updated_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="flex gap-2 ml-4">
                                            <a href="{{ route('notes.edit', $note) }}" 
                                               class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('notes.destroy', $note) }}" 
                                                  onsubmit="return confirm('Are you sure you want to delete this note?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $notes->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400 mb-4">
                                @if(request('search'))
                                    No notes found matching "{{ request('search') }}".
                                @else
                                    You haven't created any notes yet.
                                @endif
                            </p>
                            <a href="{{ route('notes.create') }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Your First Note
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 