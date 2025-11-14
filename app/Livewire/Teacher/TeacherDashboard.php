<?php

namespace App\Livewire\Teacher;

use App\Models\ClassSubject;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Livewire\Component;

class TeacherDashboard extends Component
{
    public $todaysSchedule = [];
    public $assignedClasses = [];

    public function mount()
    {
        $teacher = Auth::user()->staff;

        if (!$teacher) {
            return;
        }

        // Get today's schedule
        $today = Carbon::now()->format('l'); // 'l' gives the full day name, e.g., "Monday"
        $this->todaysSchedule = Timetable::where('staff_id', $teacher->id)
            ->where('day_of_week', $today)
            ->with(['subject', 'schoolClass', 'classArm'])
            ->orderBy('start_time')
            ->get();

        // Get all assigned classes and subjects
        $this->assignedClasses = ClassSubject::whereHas('teachers', function ($query) use ($teacher) {
            $query->where('staff.id', $teacher->id);
        })
        ->with(['schoolClass', 'subject'])
        ->get()
        ->groupBy('schoolClass.name');
    }

    public function render()
    {
        return view('livewire.teacher.teacher-dashboard');
    }
}