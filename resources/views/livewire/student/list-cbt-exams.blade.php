<div class="space-y-6">
    @forelse($availableExams as $exam)
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 flex flex-col md:flex-row justify-between md:items-center">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $exam->title }}</h3>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <span><strong>Subject:</strong> {{ $exam->subject->name }}</span>
                        <span><strong>Duration:</strong> {{ $exam->duration_minutes }} minutes</span>
                        <span><strong>Questions:</strong> {{ $exam->questions_count }}</span>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex-shrink-0">
                    <a href="{{ route('student.cbt.take', $exam) }}" class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                        Start Exam
                    </a>
                </div>
            </div>
            @if($exam->instructions)
            <div class="px-6 pb-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mt-3">Instructions:</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $exam->instructions }}</p>
            </div>
            @endif
        </div>
    @empty
        <div class="bg-white dark:bg-gray-800 text-center p-12 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">No CBT Exams Available</h3>
            <p class="mt-1 text-sm text-gray-500">There are no new exams for you at this time. Please check back later.</p>
        </div>
    @endforelse
</div>