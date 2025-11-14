<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Fees & Structures') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Fee Types Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Fee Types</h3>
                    <x-button wire:click="openFeeTypeModal()">Add Fee Type</x-button>
                </div>
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-3" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                <!-- Fee Types Table -->
                <table class="min-w-full divide-y divide-gray-200 mt-4">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                        @forelse($feeTypes as $type)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $type->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <!-- Add Edit/Delete buttons later -->
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center p-4">No fee types found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $feeTypes->links() }}</div>
            </div>

            <!-- Fee Structures Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Fee Structures</h3>
                    <x-button wire:click="openFeeStructureModal()">Set Fee Structure</x-button>
                </div>
                 @if (session()->has('structure_message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-3" role="alert">
                        {{ session('structure_message') }}
                    </div>
                @endif
                <!-- Fee Structures Table -->
                <table class="min-w-full divide-y divide-gray-200 mt-4">
                     <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Class</th>
                            <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fee</th>
                            <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                        @forelse($feeStructures as $structure)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $structure->schoolClass->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $structure->feeType->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">₦{{ number_format($structure->amount, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center p-4">No fee structures found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                 <div class="mt-4">{{ $feeStructures->links() }}</div>
            </div>
        </div>

        <!-- Fee Type Modal -->
        <x-dialog-modal wire:model.live="showFeeTypeModal">
            <x-slot name="title">{{ $isFeeTypeEditMode ? 'Edit Fee Type' : 'Add New Fee Type' }}</x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label for="name" value="Fee Name (e.g., Tuition Fees)" />
                    <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <x-label for="description" value="Description (Optional)" />
                    <textarea id="description" wire:model="description" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('showFeeTypeModal')">Cancel</x-secondary-button>
                <x-button class="ml-2" wire:click="{{ $isFeeTypeEditMode ? 'updateFeeType' : 'storeFeeType' }}">Save</x-button>
            </x-slot>
        </x-dialog-modal>

        <!-- Fee Structure Modal -->
        <x-dialog-modal wire:model.live="showFeeStructureModal">
            <x-slot name="title">{{ $isFeeStructureEditMode ? 'Edit Fee Structure' : 'Set New Fee Structure' }}</x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label for="school_class_id" value="Select Class" />
                    <select id="school_class_id" wire:model="school_class_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="">-- Select Class --</option>
                        @foreach($schoolClasses as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                    @error('school_class_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <x-label for="fee_type_id" value="Select Fee Type" />
                    <select id="fee_type_id" wire:model="fee_type_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="">-- Select Fee Type --</option>
                        @foreach($allFeeTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('fee_type_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <x-label for="amount" value="Amount (₦)" />
                    <x-input id="amount" type="number" step="0.01" class="mt-1 block w-full" wire:model="amount" />
                    @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('showFeeStructureModal')">Cancel</x-secondary-button>
                <x-button class="ml-2" wire:click="{{ $isFeeStructureEditMode ? 'updateFeeStructure' : 'storeFeeStructure' }}">Save Structure</x-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>