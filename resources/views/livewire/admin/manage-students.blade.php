<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Students') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                 @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {!! session('message') !!}
                    </div>
                @endif
                 @if (session()->has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {!! session('error') !!}
                    </div>
                @endif

                <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0">
                    <x-input type="text" wire:model.live.debounce.300ms="search" placeholder="Search students by name or admission no..." class="w-full md:w-1/3"/>
                    <div class="flex space-x-2">
                        <!-- We will add the bulk import button to the Class Roster page later -->
                        <x-button wire:click="openModal()">Admit New Student</x-button>
                    </div>
                </div>

                <!-- Student Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Admission No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Class</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($students as $student)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $student->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $student->admission_no }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $student->schoolClass->name }} {{ $student->classArm->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <x-secondary-button wire:click="edit({{ $student->id }})">Edit</x-secondary-button>
                                    <x-danger-button wire:click="delete({{ $student->id }})" wire:confirm="Are you sure? This will delete the user and all related student data.">Delete</x-danger-button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">No students found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $students->links() }}</div>
            </div>
        </div>

        <!-- THIS IS THE MISSING MODAL WINDOW -->
        <x-dialog-modal wire:model.live="showModal">
            <x-slot name="title">{{ $isEditMode ? 'Edit Student Record' : 'Admit New Student' }}</x-slot>
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
                     <!-- Admission No -->
                    <div class="mb-4">
                        <x-label for="admission_no" value="Admission Number" />
                        <x-input id="admission_no" type="text" class="mt-1 block w-full" wire:model="admission_no" />
                        @error('admission_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <!-- Date of Birth -->
                    <div class="mb-4">
                        <x-label for="date_of_birth" value="Date of Birth" />
                        <x-input id="date_of_birth" type="date" class="mt-1 block w-full" wire:model="date_of_birth" />
                        @error('date_of_birth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <!-- Gender -->
                    <div class="mb-4">
                        <x-label for="gender" value="Gender" />
                        <select id="gender" wire:model="gender" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <!-- Class -->
                    <div class="mb-4">
                        <x-label for="school_class_id" value="Class" />
                        <select id="school_class_id" wire:model="school_class_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="">Select Class</option>
                            @foreach($schoolClasses as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('school_class_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <!-- Class Arm -->
                    <div class="mb-4">
                        <x-label for="class_arm_id" value="Class Arm" />
                        <select id="class_arm_id" wire:model="class_arm_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="">Select Arm</option>
                             @foreach($classArms as $arm)
                            <option value="{{ $arm->id }}">{{ $arm->name }}</option>
                            @endforeach
                        </select>
                        @error('class_arm_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="closeModal()">Cancel</x-secondary-button>
                <x-button class="ml-2" wire:click="{{ $isEditMode ? 'update' : 'store' }}">Save Student</x-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>