<?php

namespace App\Livewire\Admin;

use App\Models\SchoolClass;
use App\Models\Term;
use App\Models\Student;
use App\Models\ExamScore;
use App\Models\Result;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProcessResults extends Component
{
    public $selectedClassId, $selectedTermId;
    public $processingMessage = '';

    public function processResults()
    {
        $this->validate([
            'selectedClassId' => 'required|exists:school_classes,id',
            'selectedTermId' => 'required|exists:terms,id',
        ]);

        // 1. Get all students in the class
        $students = Student::where('school_class_id', $this->selectedClassId)->get();
        if ($students->isEmpty()) {
            $this->processingMessage = 'Error: No students found in this class.';
            return;
        }

        $studentResults = [];

        // 2. Calculate total score for each student
        foreach ($students as $student) {
            $totalScore = ExamScore::where('student_id', $student->id)
                ->where('term_id', $this->selectedTermId)
                ->sum('score');
            
            $studentResults[] = [
                'student_id' => $student->id,
                'total_score' => $totalScore,
            ];
        }

        // 3. Sort students by total score to determine position
        usort($studentResults, function ($a, $b) {
            return $b['total_score'] <=> $a['total_score'];
        });

        // 4. Get the number of subjects for average calculation
        $subjectCount = ExamScore::where('term_id', $this->selectedTermId)
            ->where('student_id', $students->first()->id)
            ->count();
        
        if ($subjectCount == 0) {
            $this->processingMessage = 'Error: No scores found for this class and term. Cannot calculate average.';
            return;
        }

        // 5. Save the processed result for each student
        foreach ($studentResults as $index => $resultData) {
            $position = $index + 1;
            $average = $resultData['total_score'] / $subjectCount;

            Result::updateOrCreate(
                [
                    'student_id' => $resultData['student_id'],
                    'term_id' => $this->selectedTermId,
                ],
                [
                    'total_score' => $resultData['total_score'],
                    'average' => $average,
                    'position' => $position,
                    'remarks' => 'Auto-generated remark', // Can be improved with grading system
                ]
            );
        }

        $this->processingMessage = 'Success: Results for ' . $students->count() . ' students have been processed.';
    }

    public function render()
    {
        return view('livewire.admin.process-results', [
            'schoolClasses' => SchoolClass::all(),
            'terms' => Term::with('academicSession')->get(),
        ]);
    }
}