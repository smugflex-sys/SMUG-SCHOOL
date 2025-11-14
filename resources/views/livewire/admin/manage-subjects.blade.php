<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage & Assign Subjects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Manage Subjects Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">All Subjects</h3>
                    <x-button wire:click="openSubjectModal()">Add Subject</x-button>
                </div>
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-3" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                <!-- Subjects Table -->
                <table class="min-w-full divide-y divide-gray-200 mt-4">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                        @foreach($subjects as $subject)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $subject->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $subject->subject_code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <x-secondary-button wire:click="editSubject({{ $subject->id }})">Edit</x-secondary-button>
                                <x-danger-button wire:click="deleteSubject({{ $subject->id }})" wire:confirm="Are you sure?">Delete</x-danger-button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $subjects->links() }}</div>
            </div>

            <!-- Assign Subjects Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                 <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Assign Subjects to Classes</h3>
                 @if (session()->has('assign_message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-3" role="alert">
                        {{ session('assign_message') }}
                    </div>
                @endif
                <div class="mt-4 space-y-4">
                    @foreach($schoolClasses as $class)
                        <div class="p-4 border rounded-lg">
                            <div class="flex justify-between items-center">
                                <p class="font-semibold">{{ $class->name }}</p>
                                <x-button wire:click="openAssignModal({{ $class->id }})">Manage Subjects</x-button>
                            </div>
                            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                @forelse($class->subjects as $subject)
                                    <span class="inline-block bg-gray-200 dark:bg-gray-700 rounded-full px-3 py-1 text-xs font-semibold text-gray-700 dark:text-gray-200 mr-2 mb-2">
                                        {{ $subject->name }}
                                    </span>
                                @empty
                                    <span>No subjects assigned yet.</span>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Subject Modal -->
        <x-dialog-modal wire:model.live="showSubjectModal">
            <x-slot name="title">{{ $isSubjectEditMode ? 'Edit Subject' : 'Add New Subject' }}</x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label for="name" value="Subject Name" />
                    <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                 <div class="mb-4">
                    <x-label for="subject_code" value="Subject Code" />
                    <x-input id="subject_code" type="text" class="mt-1 block w-full" wire:model="subject_code" />
                    @error('subject_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="closeSubjectModal()">Cancel</x-secondary-button>
                <x-button class="ml-2" wire:click="{{ $isSubjectEditMode ? 'updateSubject' : 'storeSubject' }}">Save</x-button>
            </x-slot>
        </x-dialog-modal>

        <!-- Assign Modal -->
        <x-dialog-modal wire:model.live="showAssignModal">
            <x-slot name="title">Assign Subjects</x-slot>
            <x-slot name="content">
                <p class="mb-4">Select the subjects for this class:</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($allSubjects as $subject)
                        <label class="flex items-center">
                            <x-checkbox wire:model="subjectIds" value="{{ $subject->id }}" />
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-200">{{ $subject->name }}</span>
                        </label>
                    @endforeach
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="closeAssignModal()">Cancel</x-secondary-button>
                <x-button class="ml-2" wire:click="saveAssignments()">Save Assignments</x-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>