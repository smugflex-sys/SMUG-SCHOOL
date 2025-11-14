<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Librarian Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-gray-500 text-sm font-medium">Total Books in Catalog</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $totalBooks }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-gray-500 text-sm font-medium">Books Currently Issued</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $booksIssued }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-gray-500 text-sm font-medium">Books Overdue</h3>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-500 mt-2">{{ $booksOverdue }}</p>
                </div>
            </div>

            <!-- Quick Actions & Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg flex flex-col justify-center items-center space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Quick Actions</h3>
                     <a href="{{ route('librarian.books.index') }}" class="w-full text-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">Manage Catalog</a>
                     <a href="{{ route('librarian.issue-return.index') }}" class="w-full text-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">Issue / Return Books</a>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Recently Returned Books</h3>
                    <div class="space-y-4">
                         @forelse($recentlyReturned as $issue)
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $issue->book->title }}</p>
                                    <p class="text-xs text-gray-500">Returned by {{ $issue->user->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($issue->return_date)->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">No books have been returned recently.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>