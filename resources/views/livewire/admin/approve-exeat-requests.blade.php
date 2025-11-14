<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Approve Exeat Requests') }}
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
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Pending Requests</h3>
                
                <div class="space-y-4">
                    @forelse($requests as $request)
                        <div class="p-4 border dark:border-gray-700 rounded-lg">
                            <div class="flex flex-col md:flex-row justify-between md:items-center">
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-gray-100">Student: {{ $request->student->user->name }}</p>
                                    <p class="text-sm text-gray-500">Parent: {{ $request->parent->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2"><strong>Reason:</strong> {{ $request->reason }}</p>
                                    <p class="text-xs text-gray-500 mt-1"><strong>Departs:</strong> {{ $request->departure_time->format('D, M j, Y - g:i A') }}</p>
                                    <p class="text-xs text-gray-500"><strong>Returns:</strong> {{ $request->expected_return_time->format('D, M j, Y - g:i A') }}</p>
                                </div>
                                <div class="mt-4 md:mt-0 flex-shrink-0 flex space-x-2 self-end md:self-center">
                                    <x-button wire:click="openActionModal({{ $request->id }}, 'approve')">Approve</x-button>
                                    <x-danger-button wire:click="openActionModal({{ $request->id }}, 'deny')">Deny</x-danger-button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-10">There are no pending exeat requests.</p>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Action Modal -->
    <x-dialog-modal wire:model.live="showActionModal">
        <x-slot name="title">
            {{ Str::title($actionType ?? '') }} Exeat Request
        </x-slot>

        <x-slot name="content">
            <p>You are about to {{ $actionType }} the exeat request for <span class="font-bold">{{ $selectedRequest?->student->user->name }}</span>.</p>
            
            <div class="mt-4">
                <x-label for="admin_remarks" value="Remarks (Optional)" />
                <textarea id="admin_remarks" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" wire:model="admin_remarks" placeholder="Reason for denial, instructions, etc."></textarea>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showActionModal')">Cancel</x-secondary-button>
            <x-button class="ml-2" wire:click="confirmAction" wire:loading.attr="disabled">
                Confirm {{ Str::title($actionType ?? '') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>