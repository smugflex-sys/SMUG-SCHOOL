<?php

namespace App\Livewire\Teacher;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\ClassArm;
use App\Models\AcademicSession;
use Carbon\Carbon;
use Livewire\Component;

class TakeAttendance extends Component
{
    public $selectedClassId, $selectedArmId;
    public $attendanceDate;
    public $students = [];
    public $attendance = [];

    public function mount()
    {
        $this->attendanceDate = Carbon::today()->format('Y-m-d');
    }

    public function fetchStudents()
    {
        if ($this->selectedClassId && $this->selectedArmId) {
            $this->students = Student::with('user')
                ->where('school_class_id', $this->selectedClassId)
                ->where('class_arm_id', $this->selectedArmId)
                ->get();

            // Load existing attendance for the day
            $this->loadAttendance();
        } else {
            $this->students = [];
        }
    }

    public function loadAttendance()
    {
        $this->attendance = [];
        $existingRecords = Attendance::where('attendance_date', $this->attendanceDate)
            ->whereIn('student_id', $this->students->pluck('id'))
            ->get()->keyBy('student_id');

        foreach ($this->students as $student) {
            $this->attendance[$student->id] = [
                'status' => $existingRecords[$student->id]->status ?? 'present',
                'remarks' => $existingRecords[$student->id]->remarks ?? '',
            ];
        }
    }

    public function saveAttendance()
    {
        $this->validate([
            'selectedClassId' => 'required',
            'selectedArmId' => 'required',
            'attendanceDate' => 'required|date',
        ]);

        $activeSession = AcademicSession::where('is_active', true)->first();
        if (!$activeSession) {
            session()->flash('error', 'No active academic session found. Please contact admin.');
            return;
        }

        foreach ($this->attendance as $studentId => $data) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'attendance_date' => $this->attendanceDate,
                ],
                [
                    'academic_session_id' => $activeSession->id,
                    'status' => $data['status'],
                    'remarks' => $data['remarks'],
                ]
            );
        }

        session()->flash('message', 'Attendance for ' . $this->attendanceDate . ' saved successfully.');
    }


    public function render()
    {
        return view('livewire.teacher.take-attendance', [
            'schoolClasses' => SchoolClass::all(),
            'classArms' => ClassArm::all(),
        ]);
    }
}