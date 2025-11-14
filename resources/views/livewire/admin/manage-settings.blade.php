<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('System Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <form wire:submit.prevent="saveSettings" class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">School Information</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Update your school's publicly visible details and set the active academic session.
                    </p>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 border-t dark:border-gray-700 pt-6">
                        <!-- School Name -->
                        <div class="col-span-2">
                            <x-label for="schoolName" value="{{ __('School Name') }}" />
                            <x-input id="schoolName" type="text" class="mt-1 block w-full" wire:model="schoolName" />
                            @error('schoolName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- School Address -->
                        <div class="col-span-2">
                            <x-label for="schoolAddress" value="{{ __('School Address') }}" />
                            <x-input id="schoolAddress" type="text" class="mt-1 block w-full" wire:model="schoolAddress" />
                            @error('schoolAddress') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- School Email -->
                        <div>
                            <x-label for="schoolEmail" value="{{ __('School Email') }}" />
                            <x-input id="schoolEmail" type="email" class="mt-1 block w-full" wire:model="schoolEmail" />
                            @error('schoolEmail') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- School Phone -->
                        <div>
                            <x-label for="schoolPhone" value="{{ __('School Phone Number') }}" />
                            <x-input id="schoolPhone" type="text" class="mt-1 block w-full" wire:model="schoolPhone" />
                            @error('schoolPhone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Active Academic Session -->
                        <div class="col-span-2">
                            <x-label for="activeSessionId" value="{{ __('Active Academic Session') }}" />
                            <select id="activeSessionId" wire:model="activeSessionId" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">-- Select a Session --</option>
                                @foreach($academicSessions as $session)
                                    <option value="{{ $session->id }}">{{ $session->name }}</option>
                                @endforeach
                            </select>
                            @error('activeSessionId') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 pt-6 border-t dark:border-gray-700">
                        <x-button>
                            <span wire:loading.remove wire:target="saveSettings">
                                Save Settings
                            </span>
                            <span wire:loading wire:target="saveSettings">
                                Saving...
                            </span>
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>