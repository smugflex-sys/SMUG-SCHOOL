<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Exam Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Exam Types Section -->
            <div class="md:col-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Exam Types</h3>
                    <x-button wire:click="openExamTypeModal()">Add</x-button>
                </div>
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-3" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                <!-- Exam Types Table -->
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($examTypes as $type)
                        <tr>
                            <td class="px-2 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $type->name }}</td>
                            <td class="px-2 py-3 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="editExamType({{ $type->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                <button wire:click="deleteExamType({{ $type->id }})" wire:confirm="Are you sure?" class="text-red-600 hover:text-red-900 ml-2">Del</button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center p-4 text-gray-500">No exam types found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $examTypes->links() }}</div>
            </div>

            <!-- Grading System Section -->
            <div class="md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Grading System</h3>
                    <x-button wire:click="openGradeModal()">Add Grade Rule</x-button>
                </div>
                 @if (session()->has('grade_message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-3" role="alert">
                        {{ session('grade_message') }}
                    </div>
                @endif
                <!-- Grading System Table -->
                <div class="overflow-x-auto mt-4">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                         <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Grade</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Range</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Remark</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($gradingSystems as $grade)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-gray-100">{{ $grade->grade_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $grade->mark_from }}% - {{ $grade->mark_to }}%</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $grade->remark }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="editGrade({{ $grade->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                    <button wire:click="deleteGrade({{ $grade->id }})" wire:confirm="Are you sure?" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center p-4 text-gray-500">No grading rules defined.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 <div class="mt-4">{{ $gradingSystems->links() }}</div>
            </div>
        </div>

        <!-- Add/Edit Exam Type Modal -->
        <x-dialog-modal wire:model.live="showExamTypeModal">
            <x-slot name="title">{{ $isExamTypeEditMode ? 'Edit Exam Type' : 'Add New Exam Type' }}</x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label for="examTypeName" value="Exam Name (e.g., Mid-Term)" />
                    <x-input id="examTypeName" type="text" class="mt-1 block w-full" wire:model="examTypeName" />
                    @error('examTypeName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="closeExamTypeModal()">Cancel</x-secondary-button>
                <x-button class="ml-2" wire:click="{{ $isExamTypeEditMode ? 'updateExamType' : 'storeExamType' }}">Save</x-button>
            </x-slot>
        </x-dialog-modal>

        <!-- Add/Edit Grade Modal -->
        <x-dialog-modal wire:model.live="showGradeModal">
            <x-slot name="title">{{ $isGradeEditMode ? 'Edit Grade Rule' : 'Add New Grade Rule' }}</x-slot>
            <x-slot name="content">
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <x-label for="grade_name" value="Grade (e.g., A1, C4)" />
                        <x-input id="grade_name" type="text" class="mt-1 block w-full" wire:model="grade_name" />
                        @error('grade_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                     <div class="mb-4">
                        <x-label for="remark" value="Remark (e.g., Excellent)" />
                        <x-input id="remark" type="text" class="mt-1 block w-full" wire:model="remark" />
                        @error('remark') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                     <div class="mb-4">
                        <x-label for="mark_from" value="Mark From (%)" />
                        <x-input id="mark_from" type="number" class="mt-1 block w-full" wire:model="mark_from" />
                        @error('mark_from') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                     <div class="mb-4">
                        <x-label for="mark_to" value="Mark To (%)" />
                        <x-input id="mark_to" type="number" class="mt-1 block w-full" wire:model="mark_to" />
                        @error('mark_to') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="closeGradeModal()">Cancel</x-secondary-button>
                <x-button class="ml-2" wire:click="{{ $isGradeEditMode ? 'updateGrade' : 'storeGrade' }}">Save Rule</x-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>