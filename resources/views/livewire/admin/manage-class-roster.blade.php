<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Manage Roster for: {{ $schoolClass->name }} - {{ $classArm->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- ... (Add your message and error session flashes here) ... -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Class List</h3>
                    <x-button wire:click="openImportModal()">Bulk Import Students</x-button>
                </div>
                <!-- Table to display students from $this->students -->
            </div>
        </div>
    </div>

    <!-- Bulk Import Modal -->
    <x-dialog-modal wire:model.live="showImportModal">
        <!-- ... (The bulk import modal code from the previous response goes here) ... -->
    </x-dialog-modal>
</div>