<?php

namespace App\Livewire\Admin;

use App\Models\Subject;
use App\Models\SchoolClass;
use Livewire\Component;
use Livewire\WithPagination;

class ManageSubjects extends Component
{
    use WithPagination;

    // Subject properties
    public $name, $subject_code, $subjectId;
    public $showSubjectModal = false;
    public $isSubjectEditMode = false;

    // Assignment properties
    public $selectedClassId, $subjectIds = [];
    public $showAssignModal = false;

    protected function subjectRules()
    {
        return [
            'name' => 'required|string',
            'subject_code' => 'required|string|unique:subjects,subject_code,' . $this->subjectId,
        ];
    }

    // Subject Modal methods
    public function openSubjectModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'subject_code', 'subjectId', 'isSubjectEditMode']);
        $this->showSubjectModal = true;
    }

    public function closeSubjectModal()
    {
        $this->showSubjectModal = false;
    }

    // Subject CRUD
    public function storeSubject()
    {
        $this->validate($this->subjectRules());
        Subject::create(['name' => $this->name, 'subject_code' => $this->subject_code]);
        session()->flash('message', 'Subject created successfully.');
        $this->closeSubjectModal();
    }

    public function editSubject($id)
    {
        $subject = Subject::findOrFail($id);
        $this->subjectId = $id;
        $this->name = $subject->name;
        $this->subject_code = $subject->subject_code;
        $this->isSubjectEditMode = true;
        $this->showSubjectModal = true;
    }

    public function updateSubject()
    {
        $this->validate($this->subjectRules());
        Subject::findOrFail($this->subjectId)->update(['name' => $this->name, 'subject_code' => $this->subject_code]);
        session()->flash('message', 'Subject updated successfully.');
        $this->closeSubjectModal();
    }

    public function deleteSubject($id)
    {
        Subject::findOrFail($id)->delete();
        session()->flash('message', 'Subject deleted successfully.');
    }

    // Assignment Modal methods
    public function openAssignModal($classId)
    {
        $this->selectedClassId = $classId;
        $schoolClass = SchoolClass::findOrFail($classId);
        $this->subjectIds = $schoolClass->subjects()->pluck('subjects.id')->toArray();
        $this->showAssignModal = true;
    }

    public function closeAssignModal()
    {
        $this->showAssignModal = false;
    }

    public function saveAssignments()
    {
        $schoolClass = SchoolClass::findOrFail($this->selectedClassId);
        // Sync will add new and remove old associations
        $schoolClass->subjects()->sync($this->subjectIds);
        session()->flash('assign_message', 'Subjects assigned to class successfully.');
        $this->closeAssignModal();
    }

    public function render()
    {
        return view('livewire.admin.manage-subjects', [
            'subjects' => Subject::latest()->paginate(5, ['*'], 'subjectsPage'),
            'schoolClasses' => SchoolClass::with('subjects')->get(),
            'allSubjects' => Subject::all(),
        ]);
    }
}