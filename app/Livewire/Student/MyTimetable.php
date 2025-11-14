<?php

namespace App\Livewire\Student;

use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyTimetable extends Component
{
    public $timetable = [];
    public $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    public function mount()
    {
        $student = Auth::user()->student;
        $this->timetable = Timetable::where('school_class_id', $student->school_class_id)
            ->where('class_arm_id', $student->class_arm_id)
            ->with(['subject', 'staff.user'])
            ->get()
            ->groupBy('day_of_week')
            ->map(function ($day) {
                return $day->sortBy('start_time');
            });
    }

    public function render()
    {
        return view('livewire.student.my-timetable');
    }
}