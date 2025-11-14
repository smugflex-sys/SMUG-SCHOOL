<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Book Catalog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Main Content: Books Table -->
                <div class="md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Book List</h3>
                        <x-button wire:click="openBookModal()">Add New Book</x-button>
                    </div>
                    @if (session()->has('message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-3" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    <!-- Books Table -->
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Title</th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Author</th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Qty</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                @forelse($books as $book)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $book->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $book->author }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $book->available_quantity }}/{{ $book->quantity }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center p-4">No books found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $books->links() }}</div>
                </div>

                <!-- Sidebar: Categories -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Categories</h3>
                        <x-button wire:click="openCategoryModal()">Add</x-button>
                    </div>
                    @if (session()->has('category_message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-3" role="alert">
                            {{ session('category_message') }}
                        </div>
                    @endif
                    <ul class="mt-4 space-y-2">
                        @foreach($categories as $category)
                            <li class="p-2 border rounded-lg text-sm">{{ $category->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Add/Edit Book Modal -->
        <x-dialog-modal wire:model.live="showBookModal">
            <x-slot name="title">{{ $isBookEditMode ? 'Edit Book' : 'Add New Book' }}</x-slot>
            <x-slot name="content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <x-label for="title" value="Book Title" />
                        <x-input id="title" type="text" class="mt-1 block w-full" wire:model="title" />
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-2">
                        <x-label for="author" value="Author" />
                        <x-input id="author" type="text" class="mt-1 block w-full" wire:model="author" />
                        @error('author') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-label for="isbn" value="ISBN (Optional)" />
                        <x-input id="isbn" type="text" class="mt-1 block w-full" wire:model="isbn" />
                    </div>
                    <div>
                        <x-label for="quantity" value="Total Quantity" />
                        <x-input id="quantity" type="number" class="mt-1 block w-full" wire:model="quantity" />
                        @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-2">
                        <x-label for="book_category_id" value="Category" />
                        <select id="book_category_id" wire:model="book_category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('book_category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('showBookModal')">Cancel</x-secondary-button>
                <x-button class="ml-2" wire:click="{{ $isBookEditMode ? 'updateBook' : 'storeBook' }}">Save Book</x-button>
            </x-slot>
        </x-dialog-modal>

        <!-- Add Category Modal -->
        <x-dialog-modal wire:model.live="showCategoryModal">
            <x-slot name="title">Add New Category</x-slot>
            <x-slot name="content">
                <x-label for="categoryName" value="Category Name" />
                <x-input id="categoryName" type="text" class="mt-1 block w-full" wire:model="categoryName" />
                @error('categoryName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('showCategoryModal')">Cancel</x-secondary-button>
                <x-button class="ml-2" wire:click="storeCategory">Save Category</x-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>