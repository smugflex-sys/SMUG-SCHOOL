<?php

namespace App\Livewire\Student;

use App\Models\Result;
use App\Models\Term;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyResults extends Component
{
    public $results;

    public function mount()
    {
        $studentId = Auth::user()->student->id;
        $this->results = Result::where('student_id', $studentId)
            ->with('term.academicSession')
            ->orderBy('term_id', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.student.my-results');
    }
}