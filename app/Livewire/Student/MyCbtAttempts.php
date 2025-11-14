<?php

namespace App\Livewire\Student;

use App\Models\CbtAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyCbtAttempts extends Component
{
    public $attempts = [];
    
    // For the review modal
    public $reviewingAttempt;
    public $reviewAnswers = [];
    public $showReviewModal = false;

    public function mount()
    {
        $studentId = Auth::user()->student->id;
        $this->attempts = CbtAttempt::where('student_id', $studentId)
            ->where('status', 'completed')
            ->with('exam.subject', 'exam.questions')
            ->latest()
            ->get();
    }

    public function openReviewModal(CbtAttempt $attempt)
    {
        $this->reviewingAttempt = $attempt;
        $this->reviewAnswers = $attempt->answers()->with('question')->get();
        $this->showReviewModal = true;
    }

    public function render()
    {
        return view('livewire.student.my-cbt-attempts');
    }
}