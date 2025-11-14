<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Issue & Return Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Issue Book Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Issue a New Book</h3>
                    <div class="mt-4 space-y-4">
                        <!-- User Search -->
                        <div class="relative">
                            <x-label for="userSearch" value="Search Student/Staff" />
                            <x-input id="userSearch" type="text" class="mt-1 block w-full" wire:model.live.debounce.300ms="userSearch" placeholder="Enter name or email" />
                            @if(!empty($users))
                                <ul class="absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1">
                                    @foreach($users as $user)
                                        <li class="px-4 py-2 cursor-pointer hover:bg-gray-100" wire:click="selectUser({{ $user->id }})">{{ $user->name }} ({{ $user->email }})</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <!-- Book Search -->
                        <div class="relative">
                            <x-label for="bookSearch" value="Search Book" />
                            <x-input id="bookSearch" type="text" class="mt-1 block w-full" wire:model.live.debounce.300ms="bookSearch" placeholder="Enter book title" />
                             @if(!empty($books))
                                <ul class="absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1">
                                    @foreach($books as $book)
                                        <li class="px-4 py-2 cursor-pointer hover:bg-gray-100" wire:click="selectBook({{ $book->id }})">{{ $book->title }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <x-button wire:click="issueBook" :disabled="!$selectedUserId || !$selectedBookId">Issue Book</x-button>
                    </div>
                </div>

                <!-- Return Book Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Issued Books</h3>
                    <div class="mt-4 space-y-2">
                        @if($selectedUserId)
                            @forelse($issuedBooks as $issue)
                                <div class="p-3 border rounded-lg flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold">{{ $issue->book->title }}</p>
                                        <p class="text-sm text-gray-500">Due: {{ $issue->due_date->format('d M, Y') }}</p>
                                    </div>
                                    <x-secondary-button wire:click="returnBook({{ $issue->id }})">Mark as Returned</x-secondary-button>
                                </div>
                            @empty
                                <p class="text-gray-500">This user has no books currently issued.</p>
                            @endforelse
                        @else
                            <p class="text-gray-500">Select a user to see their issued books.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>