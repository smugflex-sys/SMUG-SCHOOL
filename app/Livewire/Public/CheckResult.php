<?php

namespace App\Livewire\Public;

use App\Models\ResultPin;
use App\Models\Student;
use App\Models\Term;
use Livewire\Component;

class CheckResult extends Component
{
    public $admission_no = '';
    public $pin = '';
    public $term_id = '';

    public function checkResult()
    {
        $this->validate([
            'admission_no' => 'required|string',
            'pin' => 'required|string|digits:12',
            'term_id' => 'required|exists:terms,id',
        ]);

        // 1. Validate Student
        $student = Student::where('admission_no', $this->admission_no)->first();
        if (!$student) {
            $this->addError('admission_no', 'This admission number is invalid.');
            return;
        }

        // 2. Validate PIN
        $resultPin = ResultPin::where('pin', $this->pin)->first();
        if (!$resultPin) {
            $this->addError('pin', 'This PIN is invalid.');
            return;
        }
        if (!$resultPin->is_active) {
            $this->addError('pin', 'This PIN has been deactivated.');
            return;
        }
        if ($resultPin->times_used >= $resultPin->usage_limit) {
            $this->addError('pin', 'This PIN has exceeded its usage limit.');
            return;
        }

        // 3. Increment PIN usage and redirect
        $resultPin->increment('times_used');

        return redirect()->route('result.show', [
            'studentId' => $student->id,
            'termId' => $this->term_id,
        ]);
    }

    public function render()
    {
        return view('livewire.public.check-result', [
            'terms' => Term::with('academicSession')->get()->sortByDesc('id'),
        ]);
    }
}