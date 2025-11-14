<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage School Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Upcoming & Past Events
                    </h3>
                    <x-button wire:click="openModal()">Create New Event</x-button>
                </div>

                <!-- Events List -->
                <div class="space-y-4">
                    @forelse($events as $event)
                        <div class="p-4 border dark:border-gray-700 rounded-lg flex flex-col md:flex-row justify-between items-start">
                            <div class="flex items-center">
                                <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 text-center rounded-lg p-3 w-20 flex-shrink-0">
                                    <p class="text-3xl font-bold">{{ $event->start_time->format('d') }}</p>
                                    <p class="text-sm font-semibold">{{ $event->start_time->format('M') }}</p>
                                </div>
                                <div class="ml-4">
                                    <p class="font-bold text-gray-900 dark:text-gray-100">{{ $event->title }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $event->start_time->format('D, M j, Y, g:i A') }}
                                        @if($event->end_time)
                                            - {{ $event->end_time->format('g:i A') }}
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit($event->description, 100) }}</p>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0 flex-shrink-0 flex space-x-2 self-end md:self-center">
                                <x-secondary-button wire:click="edit({{ $event->id }})">Edit</x-secondary-button>
                                <x-danger-button wire:click="delete({{ $event->id }})" wire:confirm="Are you sure you want to delete this event?">Delete</x-danger-button>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-10">No events have been created yet.</p>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Event Modal -->
    <x-dialog-modal wire:model.live="showModal">
        <x-slot name="title">
            {{ $isEditMode ? 'Edit Event' : 'Create New Event' }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-label for="title" value="{{ __('Event Title') }}" />
                <x-input id="title" type="text" class="mt-1 block w-full" wire:model="title" />
                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <x-label for="start_time" value="{{ __('Start Time') }}" />
                    <x-input id="start_time" type="datetime-local" class="mt-1 block w-full" wire:model="start_time" />
                    @error('start_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-label for="end_time" value="{{ __('End Time (Optional)') }}" />
                    <x-input id="end_time" type="datetime-local" class="mt-1 block w-full" wire:model="end_time" />
                    @error('end_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-4">
                <x-label for="description" value="{{ __('Description (Optional)') }}" />
                <textarea id="description" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" wire:model="description"></textarea>
                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal()">
                Cancel
            </x-secondary-button>

            <x-button class="ml-2" wire:click="{{ $isEditMode ? 'update' : 'store' }}">
                Save Event
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>