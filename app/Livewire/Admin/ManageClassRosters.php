<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\ClassArm;
use Livewire\Component;

class ManageClassRosters extends Component
{
    public $selectedClassId;
    public $selectedArmId;
    public $students = [];

    public function loadRoster()
    {
        $this->validate([
            'selectedClassId' => 'required|exists:school_classes,id',
            'selectedArmId' => 'required|exists:class_arms,id',
        ]);

        $this->students = Student::where('school_class_id', $this->selectedClassId)
            ->where('class_arm_id', $this->selectedArmId)
            ->with('user')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.manage-class-rosters', [
            'schoolClasses' => SchoolClass::all(),
            'classArms' => ClassArm::all(),
        ]);
    }
}