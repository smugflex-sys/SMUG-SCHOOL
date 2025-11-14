<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Promotion Engine') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Promotion Controls -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Promotion Settings</h3>
                    <div class="mt-4 space-y-4">
                        <!-- From/To Selections -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-label value="Promote From Session" />
                                <select wire:model="from_session_id" class="mt-1 block w-full ...">
                                    <option value="">Select Session</option>
                                    @foreach($sessions as $session) <option value="{{ $session->id }}">{{ $session->name }}</option> @endforeach
                                </select>
                            </div>
                            <div>
                                <x-label value="Promote To Session" />
                                <select wire:model="to_session_id" class="mt-1 block w-full ...">
                                    <option value="">Select Session</option>
                                    @foreach($sessions as $session) <option value="{{ $session->id }}">{{ $session->name }}</option> @endforeach
                                </select>
                            </div>
                            <div>
                                <x-label value="Promote From Class" />
                                <select wire:model="from_class_id" class="mt-1 block w-full ...">
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class) <option value="{{ $class->id }}">{{ $class->name }}</option> @endforeach
                                </select>
                            </div>
                            <div>
                                <x-label value="Promote To Class" />
                                <select wire:model="to_class_id" class="mt-1 block w-full ...">
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class) <option value="{{ $class->id }}">{{ $class->name }}</option> @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Promotion Criteria -->
                        <div>
                            <x-label for="promotion_pass_mark" value="Promotion Pass Mark (%)" />
                            <x-input id="promotion_pass_mark" type="number" step="0.01" class="mt-1 block w-full" wire:model="promotion_pass_mark" />
                        </div>
                        <x-button wire:click="runPromotion" wire:confirm="Are you sure? This action will move students to their new classes and cannot be undone." class="w-full justify-center">
                            Run Promotion
                        </x-button>
                    </div>
                </div>

                <!-- Promotion Log -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Promotion Log</h3>
                    @if(!empty($promotion_summary))
                        <div class="my-3 flex justify-around text-center">
                            <div><p class="text-2xl font-bold text-green-600">{{ $promotion_summary['promoted'] }}</p><p class="text-xs">Promoted</p></div>
                            <div><p class="text-2xl font-bold text-red-600">{{ $promotion_summary['repeated'] }}</p><p class="text-xs">To Repeat</p></div>
                        </div>
                    @endif
                    <div class="mt-4 h-96 overflow-y-auto border dark:border-gray-700 rounded-md p-2 space-y-1">
                        @forelse($promotion_log as $log)
                            <p class="text-sm p-1 rounded {{ str_contains($log, 'Promoted') ? 'bg-green-50 dark:bg-green-900/50' : 'bg-red-50 dark:bg-red-900/50' }}">{{ $log }}</p>
                        @empty
                            <p class="text-center text-gray-500 pt-16">Promotion log will appear here after running the process.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>