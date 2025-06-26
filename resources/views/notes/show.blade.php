<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('View Note') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('notes.edit', $note) }}" 
                   class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit Note
                </a>
                <a href="{{ route('notes.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Notes
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Title -->
                    <h1 class="text-3xl font-bold mb-4 text-gray-800 dark:text-gray-100">
                        {{ $note->title }}
                    </h1>

                    <!-- Meta -->
                    <div class="flex flex-wrap gap-4 text-sm text-gray-500 dark:text-gray-400 mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <span>
                            <strong>Created:</strong> {{ $note->created_at->format('M j, Y \a\t g:i A') }}
                        </span>
                        @if($note->updated_at != $note->created_at)
                            <span>
                                <strong>Updated:</strong> {{ $note->updated_at->format('M j, Y \a\t g:i A') }}
                            </span>
                        @endif
                        <span>
                            <strong>Last modified:</strong> {{ $note->updated_at->diffForHumans() }}
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="prose dark:prose-invert max-w-none">
                        <div class="whitespace-pre-wrap text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $note->content }}
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('notes.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            ← Back to Notes
                        </a>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('notes.edit', $note) }}" 
                               class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                Edit Note
                            </a>
                            <form method="POST" action="{{ route('notes.destroy', $note) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this note? This action cannot be undone.')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete Note
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 