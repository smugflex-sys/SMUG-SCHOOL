<?php

namespace App\Livewire\Admin;

use App\Models\SchoolClass;
use App\Models\ClassArm;
use Livewire\Component;
use Livewire\WithPagination;

class ManageClasses extends Component
{
    use WithPagination;

    // Properties for SchoolClass
    public $className, $schoolClassId;
    public $showClassModal = false;
    public $isClassEditMode = false;

    // Properties for ClassArm
    public $armName, $classArmId;
    public $showArmModal = false;
    public $isArmEditMode = false;

    // Validation Rules
    protected function classRules()
    {
        return ['className' => 'required|string|unique:school_classes,name,' . $this->schoolClassId];
    }

    protected function armRules()
    {
        return ['armName' => 'required|string|unique:class_arms,name,' . $this->classArmId];
    }

    // Methods for SchoolClass Modal
    public function openClassModal()
    {
        $this->resetValidation();
        $this->reset(['className', 'schoolClassId', 'isClassEditMode']);
        $this->showClassModal = true;
    }

    public function closeClassModal()
    {
        $this->showClassModal = false;
    }

    // Methods for ClassArm Modal
    public function openArmModal()
    {
        $this->resetValidation();
        $this->reset(['armName', 'classArmId', 'isArmEditMode']);
        $this->showArmModal = true;
    }

    public function closeArmModal()
    {
        $this->showArmModal = false;
    }

    // CRUD for SchoolClass
    public function storeClass()
    {
        $this->validate($this->classRules());
        SchoolClass::create(['name' => $this->className]);
        session()->flash('message', 'Class created successfully.');
        $this->closeClassModal();
    }

    public function editClass($id)
    {
        $schoolClass = SchoolClass::findOrFail($id);
        $this->schoolClassId = $id;
        $this->className = $schoolClass->name;
        $this->isClassEditMode = true;
        $this->showClassModal = true;
    }

    public function updateClass()
    {
        $this->validate($this->classRules());
        $schoolClass = SchoolClass::findOrFail($this->schoolClassId);
        $schoolClass->update(['name' => $this->className]);
        session()->flash('message', 'Class updated successfully.');
        $this->closeClassModal();
    }

    public function deleteClass($id)
    {
        SchoolClass::findOrFail($id)->delete();
        session()->flash('message', 'Class deleted successfully.');
    }

    // CRUD for ClassArm
    public function storeArm()
    {
        $this->validate($this->armRules());
        ClassArm::create(['name' => $this->armName]);
        session()->flash('arm_message', 'Class Arm created successfully.');
        $this->closeArmModal();
    }

    public function editArm($id)
    {
        $classArm = ClassArm::findOrFail($id);
        $this->classArmId = $id;
        $this->armName = $classArm->name;
        $this->isArmEditMode = true;
        $this->showArmModal = true;
    }

    public function updateArm()
    {
        $this->validate($this->armRules());
        $classArm = ClassArm::findOrFail($this->classArmId);
        $classArm->update(['name' => $this->armName]);
        session()->flash('arm_message', 'Class Arm updated successfully.');
        $this->closeArmModal();
    }

    public function deleteArm($id)
    {
        ClassArm::findOrFail($id)->delete();
        session()->flash('arm_message', 'Class Arm deleted successfully.');
    }


    public function render()
    {
        return view('livewire.admin.manage-classes', [
            'schoolClasses' => SchoolClass::latest()->paginate(5, ['*'], 'classesPage'),
            'classArms' => ClassArm::latest()->paginate(5, ['*'], 'armsPage'),
        ]);
    }
}