<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Academic Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openSession: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            <div class="flex justify-end mb-4">
                <x-button wire:click="openSessionModal()">Create New Session</x-button>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($sessions as $session)
                        <div class="p-6">
                            <div @click="openSession = (openSession === {{ $session->id }} ? null : {{ $session->id }})" class="flex justify-between items-center cursor-pointer">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                    {{ $session->name }} Academic Session
                                    @if($session->is_active)
                                        <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                    @endif
                                </h3>
                                <svg class="w-6 h-6 transition-transform" :class="{ 'transform rotate-180': openSession === {{ $session->id }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>

                            <div x-show="openSession === {{ $session->id }}" x-collapse class="mt-4">
                                <div class="border-t dark:border-gray-700 pt-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="font-semibold text-gray-700 dark:text-gray-300">Scheduled Terms</h4>
                                        <x-secondary-button wire:click="openTermModal({{ $session->id }})">Add Term</x-secondary-button>
                                    </div>
                                    <ul class="space-y-2">
                                        @forelse($session->terms as $term)
                                            <li class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-md flex justify-between items-center">
                                                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $term->name }}</span>
                                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                                    {{ $term->start_date->format('M j, Y') }} - {{ $term->end_date->format('M j, Y') }}
                                                </span>
                                            </li>
                                        @empty
                                            <li class="text-center text-gray-500 py-4">No terms have been scheduled for this session yet.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 p-8">No academic sessions found. Click "Create New Session" to begin.</p>
                    @endforelse
                </div>
            </div>
            <div class="mt-4">{{ $sessions->links() }}</div>
        </div>
    </div>
    
    <!-- Add/Edit Session Modal -->
    <x-dialog-modal wire:model.live="showSessionModal">
        <x-slot name="title">
            {{ $isSessionEditMode ? 'Edit Academic Session' : 'Create New Academic Session' }}
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label for="name" value="Session Name (e.g., 2025/2026)" />
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showSessionModal')">Cancel</x-secondary-button>
            <x-button class="ml-2" wire:click="{{ $isSessionEditMode ? 'updateSession' : 'storeSession' }}">Save Session</x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Add Term Modal -->
    <x-dialog-modal wire:model.live="showTermModal">
        <x-slot name="title">Schedule a New Term</x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label for="term_name" value="Term" />
                <select id="term_name" wire:model="term_name" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                    <option value="">Select Term</option>
                    <option value="First Term">First Term</option>
                    <option value="Second Term">Second Term</option>
                    <option value="Third Term">Third Term</option>
                </select>
                @error('term_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-label for="start_date" value="Start Date" />
                    <x-input id="start_date" type="date" class="mt-1 block w-full" wire:model="start_date" />
                    @error('start_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                 <div>
                    <x-label for="end_date" value="End Date" />
                    <x-input id="end_date" type="date" class="mt-1 block w-full" wire:model="end_date" />
                    @error('end_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showTermModal')">Cancel</x-secondary-button>
            <x-button class="ml-2" wire:click="storeTerm">Save Term</x-button>
        </x-slot>
    </x-dialog-modal>
</div>