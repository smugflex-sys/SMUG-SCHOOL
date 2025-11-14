<div class="h-screen flex flex-col" x-data="cbtTimer({{ $timeRemaining }})" x-init="startTimer()">
    <!-- Top Bar -->
    <header class="bg-white dark:bg-gray-800 shadow-md flex-shrink-0 z-10">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $exam->title }}</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ Auth::user()->name }}</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-500">Time Remaining</p>
                <div class="text-2xl font-bold text-red-600" x-text="displayTime">
                    {{ floor($timeRemaining / 60) }}:{{ str_pad($timeRemaining % 60, 2, '0', STR_PAD_LEFT) }}
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <div class="flex-grow flex overflow-y-auto">
        <div class="container mx-auto px-6 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
            
            <!-- Left Column: Question & Options -->
            <div class="lg:col-span-3 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                @if($currentQuestion)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Question {{ $currentQuestionIndex + 1 }} of {{ $totalQuestions }}</p>
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $currentQuestion->question_text }}</p>
                    </div>
                    
                    <div class="mt-6 space-y-4 border-t dark:border-gray-700 pt-6">
                        @foreach($currentQuestion->options as $key => $option)
                            <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all duration-200"
                                :class="{
                                    'border-green-500 bg-green-50 dark:bg-green-900/50': $wire.studentAnswers[{{$currentQuestion->id}}] === '{{$key}}',
                                    'border-gray-200 dark:border-gray-700 hover:border-gray-400 dark:hover:border-gray-500': $wire.studentAnswers[{{$currentQuestion->id}}] !== '{{$key}}'
                                }">
                                <input type="radio" wire:model.live="studentAnswers.{{$currentQuestion->id}}" value="{{ $key }}" class="h-5 w-5 text-green-600 border-gray-300 focus:ring-green-500">
                                <span class="ml-4 text-gray-700 dark:text-gray-300">{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Column: Navigation Palette -->
            <div class="lg:col-span-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-4">Question Palette</h3>
                <div class="grid grid-cols-5 gap-2">
                    @foreach($questions as $index => $question)
                        <button wire:click="goToQuestion({{ $index }})" class="w-10 h-10 flex items-center justify-center rounded-md font-semibold transition-all duration-200"
                            :class="{
                                'bg-green-600 text-white': {{ $studentAnswers[$question->id] !== null ? 'true' : 'false' }},
                                'bg-indigo-600 text-white': {{ $currentQuestionIndex === $index ? 'true' : 'false' }},
                                'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600': {{ $studentAnswers[$question->id] === null && $currentQuestionIndex !== $index ? 'true' : 'false' }}
                            }">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>

                <div class="mt-8 border-t dark:border-gray-700 pt-6 space-y-4">
                    <div class="flex justify-between">
                        <x-secondary-button wire:click="previousQuestion" :disabled="$currentQuestionIndex === 0">Previous</x-secondary-button>
                        <x-secondary-button wire:click="nextQuestion" :disabled="$currentQuestionIndex === $totalQuestions - 1">Next</x-secondary-button>
                    </div>
                    <x-button class="w-full justify-center" wire:click="submitExam" wire:confirm="Are you sure you want to submit your exam? This action cannot be undone.">
                        Submit Exam
                    </x-button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function cbtTimer(seconds) {
            return {
                timeLeft: seconds,
                displayTime: '',
                startTimer() {
                    this.updateDisplay();
                    const timer = setInterval(() => {
                        this.timeLeft--;
                        this.updateDisplay();
                        if (this.timeLeft <= 0) {
                            clearInterval(timer);
                            // Automatically submit the exam when time runs out
                            @this.call('submitExam');
                        }
                    }, 1000);
                },
                updateDisplay() {
                    const minutes = Math.floor(this.timeLeft / 60);
                    const seconds = this.timeLeft % 60;
                    this.displayTime = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                }
            }
        }
    </script>
    @endpush
</div>