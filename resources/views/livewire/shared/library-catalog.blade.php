<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Library Catalog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <x-label for="search" value="Search by Title or Author" />
                        <x-input id="search" type="text" class="mt-1 block w-full" wire:model.live.debounce.300ms="search" placeholder="e.g., Things Fall Apart or Chinua Achebe" />
                    </div>
                    <div>
                        <x-label for="selectedCategoryId" value="Filter by Category" />
                        <select id="selectedCategoryId" wire:model.live="selectedCategoryId" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Book Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($books as $book)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg flex flex-col">
                        <div class="p-6 flex-grow">
                            <p class="text-xs text-indigo-500 dark:text-indigo-400 font-semibold">{{ $book->category->name }}</p>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 mt-2">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">by {{ $book->author }}</p>
                        </div>
                        <div class="p-6 bg-gray-50 dark:bg-gray-700">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                {{ $book->available_quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                Available: {{ $book->available_quantity }} / {{ $book->quantity }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 dark:text-gray-400 py-12">
                        <p>No books found matching your criteria.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>