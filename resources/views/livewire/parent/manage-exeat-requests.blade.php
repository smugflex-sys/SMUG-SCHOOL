<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Digital Exeat Requests') }}
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
                        My Exeat History
                    </h3>
                    <x-button wire:click="openModal()">Request New Exeat</x-button>
                </div>

                <!-- Exeat Requests List -->
                <div class="space-y-4">
                    @forelse($requests as $request)
                        <div class="p-4 border dark:border-gray-700 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-200">For: {{ $request->student->user->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $request->reason }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Departs: {{ $request->departure_time->format('D, M j, Y - g:i A') }}</p>
                                </div>
                                <div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        @if($request->status == 'approved') bg-green-100 text-green-800 @endif
                                        @if($request->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                        @if($request->status == 'denied') bg-red-100 text-red-800 @endif
                                        @if($request->status == 'completed') bg-gray-100 text-gray-800 @endif
                                        ">
                                        {{ Str::title($request->status) }}
                                    </span>
                                </div>
                            </div>
                            @if($request->status == 'approved')
                                <div class="border-t dark:border-gray-700 mt-3 pt-3 text-center">
                                    <a href="{{ route('exeat.verify', $request->token) }}" target="_blank" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">View Digital Pass (QR Code)</a>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-10">You have not made any exeat requests.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Request New Exeat Modal -->
    <x-dialog-modal wire:model.live="showModal">
        <x-slot name="title">Request New Exeat</x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label for="student_id" value="Select Ward" />
                <select id="student_id" wire:model="student_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                    <option value="">-- Please select your child --</option>
                    @foreach($wards as $ward)
                        <option value="{{ $ward->id }}">{{ $ward->user->name }}</option>
                    @endforeach
                </select>
                @error('student_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

             <div class="mb-4">
                <x-label for="reason" value="Reason for Request" />
                <textarea id="reason" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" wire:model="reason"></textarea>
                @error('reason') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-label for="departure_time" value="Departure Date & Time" />
                    <x-input id="departure_time" type="datetime-local" class="mt-1 block w-full" wire:model="departure_time" />
                    @error('departure_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-label for="expected_return_time" value="Expected Return Date & Time" />
                    <x-input id="expected_return_time" type="datetime-local" class="mt-1 block w-full" wire:model="expected_return_time" />
                    @error('expected_return_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModal')">Cancel</x-secondary-button>
            <x-button class="ml-2" wire:click="submitRequest">Submit Request</x-button>
        </x-slot>
    </x-dialog-modal>
</div>