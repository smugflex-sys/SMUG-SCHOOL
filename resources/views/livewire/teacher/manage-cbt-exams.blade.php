<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('CBT Exam Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Subject Filter -->
            <div class="mb-6">
                <x-label for="selectedSubjectIdForBank" value="Select a Subject to Manage its Question Bank" />
                <select id="selectedSubjectIdForBank" wire:model.live="selectedSubjectIdForBank" class="mt-1 block w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                    @foreach($teacherSubjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                <!-- Left Column: Question Bank -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Question Bank</h3>
                        <x-button wire:click="openQuestionModal()">Add Question</x-button>
                    </div>
                    @if (session()->has('message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-3" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="mt-4 h-[600px] overflow-y-auto space-y-3 pr-2">
                        @forelse($questionBank as $question)
                            <div class="p-3 border dark:border-gray-700 rounded-lg text-sm">
                                <p class="text-gray-800 dark:text-gray-200">{{ $question->question_text }}</p>
                                <p class="text-xs text-green-600 dark:text-green-400 mt-1">Correct Answer: {{ $question->correct_answer }}</p>
                            </div>
                        @empty
                             <div class="text-center text-gray-500 py-16">
                                <p>Your question bank for this subject is empty.</p>
                                <p class="text-xs">Click "Add Question" to start building it.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Column: Manage Exams -->
                <div class="lg:col-span-3 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">My Exams</h3>
                        <x-button wire:click="openExamModal()">Create Exam</x-button>
                    </div>
                    @if (session()->has('exam_message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-3" role="alert">
                            {{ session('exam_message') }}
                        </div>
                    @endif
                     <div class="mt-4 space-y-4">
                        @forelse($exams as $exam)
                            <div class="p-4 border dark:border-gray-700 rounded-lg flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-gray-100">{{ $exam->title }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $exam->schoolClass->name }} | {{ $exam->subject->name }} | {{ $exam->duration_minutes }} mins
                                    </p>
                                </div>
                                <x-secondary-button wire:click="openLinkModal({{ $exam->id }})">Manage Questions</x-secondary-button>
                            </div>
                        @empty
                             <div class="text-center text-gray-500 py-16">
                                <p>You have not created any exams yet.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-4">{{ $exams->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Question Modal -->
    <x-dialog-modal wire:model.live="showQuestionModal">
        <x-slot name="title">Add New Question to Bank</x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label for="question_text" value="Question" />
                <textarea id="question_text" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" wire:model="question_text"></textarea>
                @error('question_text') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                @foreach($options as $key => $value)
                <div>
                    <x-label for="options.{{$key}}" value="Option {{ $key }}" />
                    <x-input id="options.{{$key}}" type="text" class="mt-1 block w-full" wire:model="options.{{$key}}" />
                    @error('options.'.$key) <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                @endforeach
            </div>
             <div class="mt-4">
                <x-label value="Correct Answer" />
                <fieldset class="mt-2">
                    <div class="flex space-x-4">
                        @foreach($options as $key => $value)
                        <label class="flex items-center">
                            <input wire:model="correct_answer" type="radio" value="{{$key}}" class="form-radio h-4 w-4 text-green-600 border-gray-300 dark:border-gray-600 focus:ring-green-500 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Option {{ $key }}</span>
                        </label>
                        @endforeach
                    </div>
                </fieldset>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showQuestionModal')">Cancel</x-secondary-button>
            <x-button class="ml-2" wire:click="storeQuestion">Save Question</x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Create/Edit Exam Modal -->
     <x-dialog-modal wire:model.live="showExamModal">
        <x-slot name="title">{{ $isExamEditMode ? 'Edit Exam' : 'Create New Exam' }}</x-slot>
        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-label for="exam_title" value="Exam Title" />
                    <x-input id="exam_title" type="text" class="mt-1 block w-full" wire:model="exam_title" placeholder="e.g., JSS 1 First Term Mathematics Exam" />
                    @error('exam_title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-label for="exam_subject_id" value="Subject" />
                        <select id="exam_subject_id" wire:model="exam_subject_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="">Select Subject</option>
                            @foreach($teacherSubjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        @error('exam_subject_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-label for="exam_school_class_id" value="Class" />
                        <select id="exam_school_class_id" wire:model="exam_school_class_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="">Select Class</option>
                            @foreach($schoolClasses as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('exam_school_class_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div>
                    <x-label for="exam_duration_minutes" value="Duration (in minutes)" />
                    <x-input id="exam_duration_minutes" type="number" class="mt-1 block w-full" wire:model="exam_duration_minutes" />
                    @error('exam_duration_minutes') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-label for="exam_instructions" value="Instructions (Optional)" />
                    <textarea id="exam_instructions" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" wire:model="exam_instructions"></textarea>
                    @error('exam_instructions') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showExamModal')">Cancel</x-secondary-button>
            <x-button class="ml-2" wire:click="{{ $isExamEditMode ? 'updateExam' : 'storeExam' }}">Save Exam</x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Link Questions Modal -->
    <x-dialog-modal wire:model.live="showLinkModal" max-width="2xl">
        <x-slot name="title">Manage Questions for "{{ $linkingExam?->title }}"</x-slot>
        <x-slot name="content">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Select the questions from your question bank to include in this exam.</p>
            <div class="h-96 overflow-y-auto pr-2 space-y-3">
                @if($linkingExam)
                    @forelse(CbtQuestion::where('subject_id', $linkingExam->subject_id)->where('user_id', Auth::id())->get() as $question)
                        <label class="flex items-start space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600">
                            <x-checkbox wire:model="questionIdsToLink" value="{{ $question->id }}" />
                            <div class="text-sm">
                                <p class="text-gray-800 dark:text-gray-200">{{ $question->question_text }}</p>
                                <p class="text-xs text-green-600 dark:text-green-400 mt-1">Ans: {{ $question->correct_answer }}</p>
                            </div>
                        </label>
                    @empty
                        <p class="text-center text-gray-500 py-16">No questions found in the bank for this subject. Please add questions first.</p>
                    @endforelse
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showLinkModal', false)">Cancel</x-secondary-button>
            <x-button class="ml-2" wire:click="saveLinkedQuestions">Save Questions</x-button>
        </x-slot>
    </x-dialog-modal>
</div>