<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Parents') }}
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

                <div class="flex justify-end mb-4">
                    <x-button wire:click="openModal()">Add New Parent</x-button>
                </div>

                <!-- Parents Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Parent Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Linked Ward(s)</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($parents as $parent)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $parent->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $parent->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @forelse($parent->children as $child)
                                        <span class="inline-block bg-gray-100 dark:bg-gray-700 rounded-full px-3 py-1 text-xs font-semibold text-gray-700 dark:text-gray-200 mr-2 mb-1">
                                            {{ $child->user->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-red-500">Not linked</span>
                                    @endforelse
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <!-- ADDED wire:click EVENTS TO BUTTONS -->
                                    <x-secondary-button wire:click="edit({{ $parent->id }})">Edit</x-secondary-button>
                                    <x-danger-button class="ml-2" wire:click="delete({{ $parent->id }})" wire:confirm="Are you sure you want to delete this parent account? This action cannot be undone.">Delete</x-danger-button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 whitespace-nowrap text-sm text-center text-gray-500">
                                    No parent accounts have been created yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $parents->links() }}
                </div>
            </div>
        </div>

        <!-- Add/Edit Parent Modal -->
        <x-dialog-modal wire:model.live="showModal">
            <x-slot name="title">{{ $isEditMode ? 'Edit Parent Record' : 'Add New Parent' }}</x-slot>
            <x-slot name="content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <x-label for="name" value="Full Name" />
                        <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="email" value="Email" />
                        <x-input id="email" type="email" class="mt-1 block w-full" wire:model="email" />
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="mb-4">
                    <x-label for="selectedChildren" value="Link to Student(s)/Ward(s)" />
                    <div class="p-2 border dark:border-gray-700 rounded-md mt-1 h-48 overflow-y-scroll">
                        @foreach($allStudents as $student)
                            <label class="flex items-center space-x-2 p-1">
                                <x-checkbox wire:model="selectedChildren" value="{{ $student->id }}" />
                                <span class="text-gray-800 dark:text-gray-200">{{ $student->user->name }} ({{ $student->admission_no }})</span>
                            </label>
                        @endforeach
                    </div>
                    @error('selectedChildren') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('showModal')">Cancel</x-secondary-button>
                <x-button class="ml-2" wire:click="{{ $isEditMode ? 'update' : 'store' }}">Save Parent</x-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>