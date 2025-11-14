<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Staff') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                     <x-input type="text" wire:model.live.debounce.300ms="search" placeholder="Search staff..." class="w-1/3"/>
                    <x-button wire:click="openModal()">Add New Staff</x-button>
                </div>

                <!-- Staff Table -->
                 <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Staff No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                            @foreach($staffMembers as $staff)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $staff->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $staff->staff_no }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @foreach($staff->user->roles as $role)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <!-- Edit and Delete buttons here -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $staffMembers->links() }}</div>
            </div>
        </div>

        <!-- Staff Modal -->
        <x-dialog-modal wire:model.live="showModal">
            <x-slot name="title">{{ $isEditMode ? 'Edit Staff Record' : 'Add New Staff' }}</x-slot>
            <x-slot name="content">
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Name -->
                    <div class="mb-4">
                        <x-label for="name" value="Full Name" />
                        <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                     <!-- Email -->
                    <div class="mb-4">
                        <x-label for="email" value="Email" />
                        <x-input id="email" type="email" class="mt-1 block w-full" wire:model="email" />
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                     <!-- Staff No -->
                    <div class="mb-4">
                        <x-label for="staff_no" value="Staff Number" />
                        <x-input id="staff_no" type="text" class="mt-1 block w-full" wire:model="staff_no" />
                        @error('staff_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <!-- Designation -->
                    <div class="mb-4">
                        <x-label for="designation" value="Designation (e.g., Maths Teacher)" />
                        <x-input id="designation" type="text" class="mt-1 block w-full" wire:model="designation" />
                        @error('designation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <!-- Role -->
                    <div class="mb-4 col-span-2">
                        <x-label for="role_id" value="Assign Role" />
                        <select id="role_id" wire:model="role_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                 </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="closeModal()">Cancel</x-secondary-button>
                <x-button class="ml-2" wire:click="{{ $isEditMode ? 'update' : 'store' }}">Save Staff</x-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>