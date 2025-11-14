<?php

namespace App\Livewire\Admin;

use App\Models\Session;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Result;
use App\Models\PromotionLog;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PromoteStudents extends Component
{
    public $from_session_id;
    public $to_session_id;
    public $from_class_id;
    public $to_class_id;

    public $promotion_pass_mark = 50.0;
    public $promotion_log = [];
    public $promotion_summary = [];

    public function runPromotion()
    {
        $this->validate([
            'from_session_id' => 'required|exists:academic_sessions,id',
            'to_session_id' => 'required|exists:academic_sessions,id|different:from_session_id',
            'from_class_id' => 'required|exists:school_classes,id',
            'to_class_id' => 'required|exists:school_classes,id|different:from_class_id',
            'promotion_pass_mark' => 'required|numeric|min:0|max:100',
        ]);

        $this->promotion_log = [];
        $this->promotion_summary = ['promoted' => 0, 'repeated' => 0];

        $studentsToPromote = Student::where('school_class_id', $this->from_class_id)->get();

        // Find the last term of the 'from' session
        $lastTerm = Session::find($this->from_session_id)->terms()->orderBy('id', 'desc')->first();

        if (!$lastTerm) {
            session()->flash('error', 'The selected session has no terms. Cannot determine final results.');
            return;
        }

        foreach ($studentsToPromote as $student) {
            $finalResult = Result::where('student_id', $student->id)
                                ->where('term_id', $lastTerm->id)
                                ->first();

            $finalAverage = $finalResult->average ?? 0;
            $status = ($finalAverage >= $this->promotion_pass_mark) ? 'promoted' : 'repeated';

            if ($status === 'promoted') {
                $student->update(['school_class_id' => $this->to_class_id]);
                $this->promotion_summary['promoted']++;
            } else {
                $this->promotion_summary['repeated']++;
            }

            // Log the action
            PromotionLog::create([
                'student_id' => $student->id,
                'from_class_id' => $this->from_class_id,
                'to_class_id' => $this->to_class_id,
                'from_session_id' => $this->from_session_id,
                'to_session_id' => $this->to_session_id,
                'status' => $status,
                'final_average' => $finalAverage,
            ]);

            $this->promotion_log[] = "{$student->user->name} (Avg: {$finalAverage}%) - Status: " . Str::title($status);
        }

        session()->flash('message', 'Promotion process completed successfully.');
    }

    public function render()
    {
        return view('livewire.admin.promote-students', [
            'sessions' => Session::all(),
            'classes' => SchoolClass::all(),
        ]);
    }
}