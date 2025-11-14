<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View CBT Exam Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Exam List -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Select an Exam to View</h3>
                    <div class="space-y-3">
                        @foreach($teacherExams as $exam)
                            <button wire:click="viewAttempts({{ $exam->id }})" class="w-full text-left p-3 rounded-lg transition-colors {{ $selectedExam?->id === $exam->id ? 'bg-green-600 text-white' : 'bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                <p class="font-semibold">{{ $exam->title }}</p>
                                <p class="text-xs">{{ $exam->schoolClass->name }} | {{ $exam->subject->name }}</p>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Results Display -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    @if($selectedExam)
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            Submissions for: {{ $selectedExam->title }}
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Student Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Score</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Submitted</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($examAttempts as $attempt)
                                        <tr>
                                            <td class="px-6 py-4">{{ $attempt->student->user->name }}</td>
                                            <td class="px-6 py-4 font-bold">{{ $attempt->score }} / {{ $selectedExam->questions->count() }}</td>
                                            <td class="px-6 py-4 text-xs">{{ $attempt->end_time->diffForHumans() }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <x-secondary-button wire:click="openReviewModal({{ $attempt->id }})">Review</x-secondary-button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center py-8 text-gray-500">No students have completed this exam yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-16">Please select an exam from the left to view student submissions.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Review Answers Modal -->
    <x-dialog-modal wire:model.live="showReviewModal" max-width="3xl">
        <x-slot name="title">
            Reviewing Exam for {{ $reviewingAttempt?->student->user->name }}
        </x-slot>
        <x-slot name="content">
            <div class="h-96 overflow-y-auto pr-2 space-y-4">
                @foreach($reviewAnswers as $index => $answer)
                    <div class="p-3 border rounded-lg {{ $answer->is_correct ? 'border-green-300 dark:border-green-700' : 'border-red-300 dark:border-red-700' }}">
                        <p class="font-semibold text-gray-800 dark:text-gray-200">Q{{ $index + 1 }}: {{ $answer->question->question_text }}</p>
                        <p class="text-sm mt-2">Student's Answer: <span class="font-bold {{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">{{ $answer->selected_option }}</span></p>
                        @if(!$answer->is_correct)
                            <p class="text-sm">Correct Answer: <span class="font-bold text-green-600">{{ $answer->question->correct_answer }}</span></p>
                        @endif
                    </div>
                @endforeach
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showReviewModal', false)">Close</x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>