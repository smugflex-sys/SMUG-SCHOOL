<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Term;
use App\Models\Result;
use App\Models\ExamScore;
use App\Models\GradingSystem;

class ResultController extends Controller
{
    public function show($studentId, $termId)
    {
        $student = Student::with('user', 'schoolClass', 'classArm')->findOrFail($studentId);
        $term = Term::with('academicSession')->findOrFail($termId);
        $result = Result::where('student_id', $studentId)->where('term_id', $termId)->firstOrFail();
        $scores = ExamScore::with('subject')->where('student_id', $studentId)->where('term_id', $termId)->get();
        $grades = GradingSystem::all();

        return view('public.result-display', compact('student', 'term', 'result', 'scores', 'grades'));
    }
}