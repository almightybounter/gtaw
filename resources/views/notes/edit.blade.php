<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('notes.update', $note) }}">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" 
                                         :value="old('title', $note->title)" required autofocus maxlength="255" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Content -->
                        <div class="mb-6">
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea id="content" name="content" rows="10" 
                                     class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" 
                                     required maxlength="10000" 
                                     placeholder="Write your note content here...">{{ old('content', $note->content) }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Maximum 10,000 characters</p>
                        </div>

                        <!-- Note Metadata -->
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Created:</strong> {{ $note->created_at->format('M j, Y \a\t g:i A') }}
                            </p>
                            @if($note->updated_at != $note->created_at)
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Last updated:</strong> {{ $note->updated_at->format('M j, Y \a\t g:i A') }}
                                </p>
                            @endif
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <div class="flex gap-2">
                                <a href="{{ route('notes.show', $note) }}" 
                                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Cancel
                                </a>
                                <a href="{{ route('notes.index') }}" 
                                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                    Back to Notes
                                </a>
                            </div>
                            
                            <div class="flex gap-2">
                                <x-primary-button>
                                    {{ __('Update Note') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>

                    <!-- Delete Section -->
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-medium text-red-600 dark:text-red-400">Delete Note</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Permanently delete this note. This action cannot be undone.
                                </p>
                            </div>
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