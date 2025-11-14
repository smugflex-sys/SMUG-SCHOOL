<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Classes & Arms') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- School Classes Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">School Classes</h3>
                    <x-button wire:click="openClassModal()">Add Class</x-button>
                </div>
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-3" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                <!-- Class Table -->
                <table class="min-w-full divide-y divide-gray-200 mt-4">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                        @foreach($schoolClasses as $class)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $class->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <x-secondary-button wire:click="editClass({{ $class->id }})">Edit</x-secondary-button>
                                <x-danger-button wire:click="deleteClass({{ $class->id }})" wire:confirm="Are you sure you want to delete this class?">Delete</x-danger-button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $schoolClasses->links() }}</div>
            </div>

            <!-- Class Arms Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Class Arms</h3>
                    <x-button wire:click="openArmModal()">Add Arm</x-button>
                </div>
                 @if (session()->has('arm_message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-3" role="alert">
                        {{ session('arm_message') }}
                    </div>
                @endif
                <!-- Arm Table -->
                <table class="min-w-full divide-y divide-gray-200 mt-4">
                     <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                        @foreach($classArms as $arm)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $arm->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <x-secondary-button wire:click="editArm({{ $arm->id }})">Edit</x-secondary-button>
                                <x-danger-button wire:click="deleteArm({{ $arm->id }})" wire:confirm="Are you sure you want to delete this arm?">Delete</x-danger-button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
    <a href="{{ route('admin.classes.roster', ['class' => $schoolClass->id, 'arm' => $arm->id]) }}" class="text-indigo-600 hover:text-indigo-900">Manage Roster</a>
    <!-- Add edit/delete buttons for the arm itself later -->
</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                 <div class="mt-4">{{ $classArms->links() }}</div>
            </div>
        </div>

        <!-- Class Modal -->
        <x-dialog-modal wire:model.live="showClassModal">
            <x-slot name="title">{{ $isClassEditMode ? 'Edit Class' : 'Add New Class' }}</x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label for="className" value="{{ __('Class Name (e.g., JSS 1)') }}" />
                    <x-input id="className" type="text" class="mt-1 block w-full" wire:model="className" />
                    @error('className') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="closeClassModal()">Cancel</x-secondary-button>
                <x-button class="ml-2" wire:click="{{ $isClassEditMode ? 'updateClass' : 'storeClass' }}">Save</x-button>
            </x-slot>
        </x-dialog-modal>

        <!-- Arm Modal -->
        <x-dialog-modal wire:model.live="showArmModal">
            <x-slot name="title">{{ $isArmEditMode ? 'Edit Arm' : 'Add New Arm' }}</x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label for="armName" value="{{ __('Arm Name (e.g., A, Science)') }}" />
                    <x-input id="armName" type="text" class="mt-1 block w-full" wire:model="armName" />
                    @error('armName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="closeArmModal()">Cancel</x-secondary-button>
                <x-button class="ml-2" wire:click="{{ $isArmEditMode ? 'updateArm' : 'storeArm' }}">Save</x-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>