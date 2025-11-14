<?php

namespace App\Livewire\Admin;

use App\Models\ExamType;
use App\Models\GradingSystem;
use Livewire\Component;
use Livewire\WithPagination;

class ManageExams extends Component
{
    use WithPagination;

    // Properties for ExamType
    public $examTypeName, $examTypeId;
    public $showExamTypeModal = false;
    public $isExamTypeEditMode = false; // <-- THIS WAS THE LINE WITH THE TYPO, NOW FIXED

    // Properties for GradingSystem
    public $grade_name, $mark_from, $mark_to, $remark, $gradeId;
    public $showGradeModal = false;
    public $isGradeEditMode = false;

    // Validation Rules
    protected function examTypeRules()
    {
        return ['examTypeName' => 'required|string|unique:exam_types,name,' . $this->examTypeId];
    }

    protected function gradeRules()
    {
        return [
            'grade_name' => 'required|string|max:10',
            'mark_from' => 'required|integer|min:0|max:100',
            'mark_to' => 'required|integer|min:0|max:100|gte:mark_from',
            'remark' => 'required|string',
        ];
    }

    // Methods for ExamType Modal
    public function openExamTypeModal()
    {
        $this->resetValidation();
        $this->reset(['examTypeName', 'examTypeId', 'isExamTypeEditMode']);
        $this->showExamTypeModal = true;
    }

    public function closeExamTypeModal()
    {
        $this->showExamTypeModal = false;
    }

    // Methods for Grade Modal
    public function openGradeModal()
    {
        $this->resetValidation();
        $this->reset(['grade_name', 'mark_from', 'mark_to', 'remark', 'gradeId', 'isGradeEditMode']);
        $this->showGradeModal = true;
    }

    public function closeGradeModal()
    {
        $this->showGradeModal = false;
    }

    // CRUD for ExamType
    public function storeExamType()
    {
        $this->validate($this->examTypeRules());
        ExamType::create(['name' => $this->examTypeName]);
        session()->flash('message', 'Exam Type created successfully.');
        $this->closeExamTypeModal();
    }

    public function editExamType($id)
    {
        $examType = ExamType::findOrFail($id);
        $this->examTypeId = $id;
        $this->examTypeName = $examType->name;
        $this->isExamTypeEditMode = true;
        $this->showExamTypeModal = true;
    }

    public function updateExamType()
    {
        $this->validate($this->examTypeRules());
        ExamType::findOrFail($this->examTypeId)->update(['name' => $this->examTypeName]);
        session()->flash('message', 'Exam Type updated successfully.');
        $this->closeExamTypeModal();
    }

    public function deleteExamType($id)
    {
        ExamType::findOrFail($id)->delete();
        session()->flash('message', 'Exam Type deleted successfully.');
    }

    // CRUD for GradingSystem
    public function storeGrade()
    {
        $this->validate($this->gradeRules());
        GradingSystem::create([
            'grade_name' => $this->grade_name,
            'mark_from' => $this->mark_from,
            'mark_to' => $this->mark_to,
            'remark' => $this->remark,
        ]);
        session()->flash('grade_message', 'Grade rule created successfully.');
        $this->closeGradeModal();
    }
    
    public function editGrade($id)
    {
        $grade = GradingSystem::findOrFail($id);
        $this->gradeId = $id;
        $this->grade_name = $grade->grade_name;
        $this->mark_from = $grade->mark_from;
        $this->mark_to = $grade->mark_to;
        $this->remark = $grade->remark;
        $this->isGradeEditMode = true;
        $this->showGradeModal = true;
    }

    public function updateGrade()
    {
        $this->validate($this->gradeRules());
        GradingSystem::findOrFail($this->gradeId)->update([
            'grade_name' => $this->grade_name,
            'mark_from' => $this->mark_from,
            'mark_to' => $this->mark_to,
            'remark' => $this->remark,
        ]);
        session()->flash('grade_message', 'Grade rule updated successfully.');
        $this->closeGradeModal();
    }

    public function deleteGrade($id)
    {
        GradingSystem::findOrFail($id)->delete();
        session()->flash('grade_message', 'Grade rule deleted successfully.');
    }


    public function render()
    {
        return view('livewire.admin.manage-exams', [
            'examTypes' => ExamType::latest()->paginate(5, ['*'], 'examTypesPage'),
            'gradingSystems' => GradingSystem::orderBy('mark_from', 'desc')->paginate(10, ['*'], 'gradesPage'),
        ]);
    }
}