<?php

namespace App\Livewire\Student;

use App\Models\CbtExam;
use App\Models\CbtAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListCbtExams extends Component
{
    public $availableExams = [];

    public function mount()
    {
        $student = Auth::user()->student;

        // If there's no student record for this user, do nothing.
        if (!$student) {
            return;
        }

        // Get the IDs of all exams this student has already attempted
        $attemptedExamIds = CbtAttempt::where('student_id', $student->id)
            ->pluck('cbt_exam_id')
            ->toArray();

        // Find all exams that are:
        // 1. For the student's specific class
        // 2. Not yet attempted by the student
        // 3. (Optional but good practice) Currently active based on start/end dates
        $this->availableExams = CbtExam::where('school_class_id', $student->school_class_id)
            ->whereNotIn('id', $attemptedExamIds)
            // ->where('available_from', '<=', now())
            // ->where('available_to', '>=', now())
            ->with('subject')
            ->withCount('questions')
            ->get();
    }

    public function render()
    {
        return view('livewire.student.list-cbt-exams');
    }
}