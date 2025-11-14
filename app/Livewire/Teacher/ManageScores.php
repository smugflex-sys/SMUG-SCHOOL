<?php

namespace App\Livewire\Teacher;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\ClassArm;
use App\Models\Subject;
use App\Models\ExamType;
use App\Models\Term;
use App\Models\ExamScore;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ManageScores extends Component
{
    public $selectedClassId, $selectedArmId, $selectedSubjectId, $selectedExamTypeId, $selectedTermId;
    public $students = [];
    public $scores = [];
    public $score_type = 'ca1';

    public function fetchStudentsAndScores()
    {
        $this->students = [];
        if ($this->selectedClassId && $this->selectedArmId) {
            $this->students = Student::with('user')
                ->where('school_class_id', $this->selectedClassId)
                ->where('class_arm_id', $this->selectedArmId)
                ->get();
            $this->loadScores();
        }
    }

    public function loadScores()
    {
        $this->scores = [];
        if ($this->selectedSubjectId && $this->selectedExamTypeId && $this->selectedTermId) {
            $existingScores = ExamScore::where('term_id', $this->selectedTermId)
                ->where('subject_id', $this->selectedSubjectId)
                 ->where('score_type', $this->score_type)
                ->where('exam_type_id', $this->selectedExamTypeId)
                ->whereIn('student_id', $this->students->pluck('id'))
                ->get()->keyBy('student_id');

            foreach ($this->students as $student) {
                $this->scores[$student->id] = $existingScores[$student->id]->score ?? '';
            }
        }
    }

    public function saveScores()
    {
        $this->validate([
            'selectedClassId' => 'required',
            'selectedArmId' => 'required',
            'selectedSubjectId' => 'required',
            'selectedExamTypeId' => 'required',
            'selectedTermId' => 'required',
        ]);

        foreach ($this->scores as $studentId => $score) {
            if (is_numeric($score) && $score >= 0 && $score <= 100) {
                ExamScore::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'term_id' => $this->selectedTermId,
                        'subject_id' => $this->selectedSubjectId,
                        'exam_type_id' => $this->selectedExamTypeId,
                        'score_type' => $this->score_type,
                    ],
                    ['score' => $score]
                );
            }
        }
        session()->flash('message', 'Scores saved successfully.');
    }

    public function render()
    {
        // This logic needs to be refined to get subjects taught by the logged-in teacher
        $subjects = Subject::all();
        
        return view('livewire.teacher.manage-scores', [
            'schoolClasses' => SchoolClass::all(),
            'classArms' => ClassArm::all(),
            'subjects' => $subjects,
            'examTypes' => ExamType::all(),
            'terms' => Term::with('academicSession')->get(),
        ]);
    }
}