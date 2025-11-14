<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\ClassArm;
use App\Imports\StudentsImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ManageClassRoster extends Component
{
    use WithFileUploads;

    public SchoolClass $schoolClass;
    public ClassArm $classArm;
    public $students;

    public $showImportModal = false;
    public $importFile;

    public function mount(SchoolClass $class, ClassArm $arm)
    {
        $this->schoolClass = $class;
        $this->classArm = $arm;
        $this->loadStudents();
    }

    public function loadStudents()
    {
        $this->students = Student::where('school_class_id', $this->schoolClass->id)
            ->where('class_arm_id', $this->classArm->id)
            ->with('user')
            ->get();
    }

    public function openImportModal()
    {
        $this->reset('importFile');
        $this->showImportModal = true;
    }

    public function closeImportModal()
    {
        $this->showImportModal = false;
    }

    public function importStudents()
    {
        $this->validate(['importFile' => 'required|mimes:csv,xlsx,xls']);

        try {
            Excel::import(new StudentsImport($this->schoolClass->id, $this->classArm->id), $this->importFile);

            session()->flash('message', 'Students imported successfully.');
            $this->closeImportModal();
            $this->loadStudents();

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // ... (error handling logic from previous response)
        }
    }

    public function render()
    {
        return view('livewire.admin.manage-class-roster');
    }
}