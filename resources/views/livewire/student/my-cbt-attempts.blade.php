<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My CBT History & Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Completed Exams</h3>
                <div class="space-y-4">
                    @forelse($attempts as $attempt)
                        <div class="p-4 border dark:border-gray-700 rounded-lg flex justify-between items-center">
                            <div>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ $attempt->exam->title }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $attempt->exam->subject->name }} | Submitted: {{ $attempt->end_time->format('M d, Y') }}</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <p class="font-bold text-xl text-gray-800 dark:text-gray-200">{{ $attempt->score }} / {{ $attempt->exam->questions->count() }}</p>
                                <x-secondary-button wire:click="openReviewModal({{ $attempt->id }})">Review Answers</x-secondary-button>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-10">You have not completed any CBT exams yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <!-- Review Answers Modal (Same structure as teacher's, but for the student) -->
    <x-dialog-modal wire:model.live="showReviewModal" max-width="3xl">
        <x-slot name="title">
            Reviewing: {{ $reviewingAttempt?->exam->title }}
        </x-slot>
        <x-slot name="content">
            <div class="h-96 overflow-y-auto pr-2 space-y-4">
                @foreach($reviewAnswers as $index => $answer)
                    <div class="p-3 border rounded-lg {{ $answer->is_correct ? 'border-green-300 dark:border-green-700' : 'border-red-300 dark:border-red-700' }}">
                        <p class="font-semibold text-gray-800 dark:text-gray-200">Q{{ $index + 1 }}: {{ $answer->question->question_text }}</p>
                        <p class="text-sm mt-2">Your Answer: <span class="font-bold {{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">{{ $answer->selected_option }}</span></p>
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