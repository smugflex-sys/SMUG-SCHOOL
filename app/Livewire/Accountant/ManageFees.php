<?php

namespace App\Livewire\Accountant;

use App\Models\FeeType;
use App\Models\FeeStructure;
use App\Models\SchoolClass;
use Livewire\Component;
use Livewire\WithPagination;

class ManageFees extends Component
{
    use WithPagination;

    // Fee Type properties
    public $name, $description, $feeTypeId;
    public $showFeeTypeModal = false;
    public $isFeeTypeEditMode = false;

    // Fee Structure properties
    public $school_class_id, $fee_type_id, $amount;
    public $feeStructureId;
    public $showFeeStructureModal = false;
    public $isFeeStructureEditMode = false;

    // Fee Type CRUD
    public function openFeeTypeModal()
    {
        $this->reset(['name', 'description', 'feeTypeId', 'isFeeTypeEditMode']);
        $this->showFeeTypeModal = true;
    }

    public function storeFeeType()
    {
        $this->validate(['name' => 'required|string|unique:fee_types,name']);
        FeeType::create(['name' => $this->name, 'description' => $this->description]);
        session()->flash('message', 'Fee Type created successfully.');
        $this->showFeeTypeModal = false;
    }
    // ... Add edit, update, delete for FeeType

    // Fee Structure CRUD
    public function openFeeStructureModal()
    {
        $this->reset(['school_class_id', 'fee_type_id', 'amount', 'feeStructureId', 'isFeeStructureEditMode']);
        $this->showFeeStructureModal = true;
    }

    public function storeFeeStructure()
    {
        $this->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric|min:0',
        ]);

        FeeStructure::create([
            'school_class_id' => $this->school_class_id,
            'fee_type_id' => $this->fee_type_id,
            'amount' => $this->amount,
        ]);
        session()->flash('structure_message', 'Fee Structure created successfully.');
        $this->showFeeStructureModal = false;
    }
    // ... Add edit, update, delete for FeeStructure

    public function render()
    {
        return view('livewire.accountant.manage-fees', [
            'feeTypes' => FeeType::latest()->paginate(5, ['*'], 'feeTypesPage'),
            'feeStructures' => FeeStructure::with(['schoolClass', 'feeType'])->latest()->paginate(5, ['*'], 'structuresPage'),
            'schoolClasses' => SchoolClass::all(),
            'allFeeTypes' => FeeType::all(),
        ]);
    }
}