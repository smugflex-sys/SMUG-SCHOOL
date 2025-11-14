<?php

namespace App\Livewire\Teacher;

use App\Models\CbtExam;
use App\Models\CbtAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewCbtResults extends Component
{
    public $teacherExams = [];
    public $selectedExam;
    public $examAttempts = [];
    
    // For the review modal
    public $reviewingAttempt;
    public $reviewAnswers = [];
    public $showReviewModal = false;

    public function mount()
    {
        // For simplicity, we get all exams. In a real app, you'd scope this to the teacher.
        // Assumes a 'user_id' is added to the cbt_exams table in the future.
        $this->teacherExams = CbtExam::with('subject', 'schoolClass')->latest()->get();
    }

    public function viewAttempts(CbtExam $exam)
    {
        $this->selectedExam = $exam;
        $this->examAttempts = CbtAttempt::where('cbt_exam_id', $exam->id)
            ->with('student.user')
            ->orderBy('score', 'desc')
            ->get();
    }

    public function openReviewModal(CbtAttempt $attempt)
    {
        $this->reviewingAttempt = $attempt->load('student.user', 'exam');
        $this->reviewAnswers = $attempt->answers()->with('question')->get();
        $this->showReviewModal = true;
    }

    public function render()
    {
        return view('livewire.teacher.view-cbt-results');
    }
}