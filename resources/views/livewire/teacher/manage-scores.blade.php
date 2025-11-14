<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Enter Student Scores') }}
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

                <!-- Filters -->
                <div class="border dark:border-gray-700 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Filter Options</h3>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <!-- Class -->
                        <div>
                            <x-label for="selectedClassId" value="Class" />
                            <select id="selectedClassId" wire:model.live="selectedClassId" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">Select Class</option>
                                @foreach($schoolClasses as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Arm -->
                        <div>
                            <x-label for="selectedArmId" value="Arm" />
                            <select id="selectedArmId" wire:model.live="selectedArmId" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">Select Arm</option>
                                @foreach($classArms as $arm)
                                    <option value="{{ $arm->id }}">{{ $arm->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Subject -->
                        <div>
                            <x-label for="selectedSubjectId" value="Subject" />
                            <select id="selectedSubjectId" wire:model.live="selectedSubjectId" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Exam Type -->
                        <div>
                            <x-label for="selectedExamTypeId" value="Exam Type" />
                            <select id="selectedExamTypeId" wire:model.live="selectedExamTypeId" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">Select Exam</option>
                                @foreach($examTypes as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
    <x-label for="score_type" value="Assessment Type" />
    <select id="score_type" wire:model.live="score_type" class="mt-1 block w-full ...">
        <option value="ca1">1st C.A.</option>
        <option value="ca2">2nd C.A.</option>
        <option value="ca3">3rd C.A.</option>
        <option value="exam">Final Exam</option>
    </select>
</div>
                        <!-- Term -->
                        <div>
                            <x-label for="selectedTermId" value="Term" />
                            <select id="selectedTermId" wire:model.live="selectedTermId" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">Select Term</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term->id }}">{{ $term->name }} ({{ $term->academicSession->name }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Scores Table -->
                @if(count($students) > 0)
                <form wire:submit.prevent="saveScores">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Student Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Admission No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase" style="width: 150px;">Score (out of 100)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($students as $student)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $student->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $student->admission_no }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-input type="number" wire:model="scores.{{ $student->id }}" class="w-full" min="0" max="100" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-button type="submit">Save Scores</x-button>
                    </div>
                </form>
                @else
                    <p class="text-center text-gray-500 dark:text-gray-400 py-10">Please select a class, arm, and subject to see the list of students.</p>
                @endif
            </div>
        </div>
    </div>
</div>