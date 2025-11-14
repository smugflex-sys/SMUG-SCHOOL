<?php

namespace App\Livewire\Parent;

use App\Models\Session as AcademicSession;
use App\Models\Attendance;
use App\Models\Invoice;
use App\Models\Result;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ParentDashboard extends Component
{
    public $wards = [];
    public $selectedWardId;

    // Widget Data
    public $selectedWard;
    public $latestResult;
    public $attendanceStats = ['present' => 0, 'absent' => 0, 'late' => 0];
    public $outstandingBalance = 0;

    public function mount()
    {
        $this->wards = Auth::user()->children()->with('user')->get();
        
        if ($this->wards->isNotEmpty()) {
            // Set the first child as the default selected ward
            $this->selectedWardId = $this->wards->first()->id;
            $this->updateDashboardData();
        }
    }

    public function updatedSelectedWardId()
    {
        // This method is called automatically when the dropdown changes
        $this->updateDashboardData();
    }

    public function updateDashboardData()
    {
        $this->selectedWard = Student::with(['user', 'schoolClass', 'classArm'])->find($this->selectedWardId);

        if (!$this->selectedWard) return;

        // 1. Get Latest Result
        $this->latestResult = Result::where('student_id', $this->selectedWardId)
            ->with('term.academicSession')
            ->latest('term_id')
            ->first();

        // 2. Get Attendance for the current month
        $activeSession = AcademicSession::where('is_active', true)->first();
        if ($activeSession) {
            $attendances = Attendance::where('student_id', $this->selectedWardId)
                ->where('academic_session_id', $activeSession->id)
                ->whereMonth('attendance_date', now()->month)
                ->get();
            
            $this->attendanceStats['present'] = $attendances->where('status', 'present')->count();
            $this->attendanceStats['absent'] = $attendances->where('status', 'absent')->count();
            $this->attendanceStats['late'] = $attendances->where('status', 'late')->count();
        }

        // 3. Get Fee Status
        $this->outstandingBalance = Invoice::where('student_id', $this->selectedWardId)
            ->where('status', '!=', 'paid')
            ->sum(\DB::raw('total_amount - amount_paid'));
    }

    public function render()
    {
        return view('livewire.parent.parent-dashboard');
    }
}