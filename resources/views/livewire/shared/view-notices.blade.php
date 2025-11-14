<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Noticeboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @forelse($notices as $notice)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $notice->title }}</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Published by {{ $notice->author->name }} on {{ $notice->published_at->format('F d, Y') }}
                        </p>
                        <div class="mt-4 text-gray-700 dark:text-gray-300">
                            {!! nl2br(e($notice->content)) !!}
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500">
                        <p>No notices to display at the moment.</p>
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $notices->links() }}
                </div>
            </div>
        </div>
    </div>
</div>