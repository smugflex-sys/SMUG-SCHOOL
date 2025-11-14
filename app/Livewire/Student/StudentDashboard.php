<?php

namespace App\Livewire\Student;

use App\Models\Session as AcademicSession; // <-- THIS IS THE FIX: Use the correct Session model and alias it
use App\Models\Attendance;
use App\Models\Invoice;
use App\Models\Result;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentDashboard extends Component
{
    public $student;
    public $attendancePercentage = 0;
    public $outstandingInvoices = 0;
    public $subjects = [];
    public $recentResults = [];

    public function mount()
    {
        $this->student = Auth::user()->student;

        if (!$this->student) {
            return;
        }

        $activeSession = AcademicSession::where('is_active', true)->first();

        if ($activeSession) {
            // Calculate Attendance Percentage
            $totalDays = Attendance::where('student_id', $this->student->id)
                ->where('academic_session_id', $activeSession->id)
                ->count();

            $presentDays = Attendance::where('student_id', $this->student->id)
                ->where('academic_session_id', $activeSession->id)
                ->where('status', 'present')
                ->count();

            if ($totalDays > 0) {
                $this->attendancePercentage = round(($presentDays / $totalDays) * 100);
            }

            // Get Outstanding Invoices
            $this->outstandingInvoices = Invoice::where('student_id', $this->student->id)
                ->where('status', '!=', 'paid')
                ->count();
        }

        // Get Subjects for the student's class
        $this->subjects = $this->student->schoolClass->subjects;

        // Get Recent Results for the chart
        $resultsData = Result::where('student_id', $this->student->id)
            ->with('term.academicSession')
            ->orderBy('term_id', 'desc')
            ->limit(4)
            ->get()
            ->reverse();

        foreach ($resultsData as $result) {
            $this->recentResults['labels'][] = $result->term->name . ' (' . $result->term->academicSession->name . ')';
            $this->recentResults['data'][] = $result->average;
        }
        
        if (!empty($this->recentResults)) {
            $this->dispatch('updateResultsChart', ['data' => $this->recentResults]);
        }
    }

    public function render()
    {
        return view('livewire.student.student-dashboard');
    }
}