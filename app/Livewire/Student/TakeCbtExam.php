<?php

namespace App\Livewire\Student;

use App\Models\CbtExam;
use App\Models\CbtAttempt;
use App\Models\CbtAnswer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TakeCbtExam extends Component
{
    public CbtExam $exam;
    public $questions;
    public $totalQuestions;
    public $currentQuestionIndex = 0;
    public $currentQuestion;
    public $studentAnswers = [];
    public $timeRemaining; // in seconds
    public $attempt;

    public function mount(CbtExam $exam)
    {
        $this->exam = $exam;
        $this->questions = $exam->questions()->get()->shuffle(); // Shuffle questions for each attempt
        $this->totalQuestions = $this->questions->count();
        $this->currentQuestion = $this->questions[$this->currentQuestionIndex] ?? null;

        // Initialize student answers array
        foreach ($this->questions as $question) {
            $this->studentAnswers[$question->id] = null;
        }

        // Create a new attempt record
        $this->attempt = CbtAttempt::create([
            'cbt_exam_id' => $this->exam->id,
            'student_id' => Auth::user()->student->id,
            'start_time' => now(),
        ]);

        $this->timeRemaining = $this->exam->duration_minutes * 60;
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < $this->totalQuestions - 1) {
            $this->currentQuestionIndex++;
            $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
        }
    }

    public function goToQuestion($index)
    {
        if ($index >= 0 && $index < $this->totalQuestions) {
            $this->currentQuestionIndex = $index;
            $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
        }
    }

    // This method is called from the view whenever a student selects an answer
    public function updatedStudentAnswers()
    {
        // Livewire automatically saves the state, no extra code needed here for now.
    }

    public function submitExam()
    {
        $score = 0;

        // Loop through all questions in the exam
        foreach ($this->questions as $question) {
            $studentAnswer = $this->studentAnswers[$question->id] ?? null;
            $isCorrect = ($studentAnswer === $question->correct_answer);

            if ($isCorrect) {
                $score++;
            }

            // Save each individual answer to the database
            CbtAnswer::create([
                'cbt_attempt_id' => $this->attempt->id,
                'cbt_question_id' => $question->id,
                'selected_option' => $studentAnswer,
                'is_correct' => $isCorrect,
            ]);
        }

        // Update the main attempt record with the final score
        $this->attempt->update([
            'end_time' => now(),
            'score' => $score,
            'status' => 'completed',
        ]);

        // Redirect to a results summary page (can be built later)
        return redirect()->route('student.dashboard')->with('message', "Exam submitted! Your score is {$score} / {$this->totalQuestions}.");
    }

    public function render()
    {
        // Use the distraction-free layout
        return view('livewire.student.take-cbt-exam')->layout('layouts.cbt');
    }
}