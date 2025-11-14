<?php

namespace App\Livewire\Parent;

use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WardResults extends Component
{
    public $wards;
    public $selectedWardId;
    public $results = [];

    public function mount()
    {
        $this->wards = Auth::user()->children()->with('user')->get();
        if ($this->wards->isNotEmpty()) {
            $this->selectedWardId = $this->wards->first()->id;
            $this->loadResults();
        }
    }

    public function updatedSelectedWardId()
    {
        $this->loadResults();
    }

    public function loadResults()
    {
        $this->results = Result::where('student_id', $this->selectedWardId)
            ->with('term.academicSession')
            ->orderBy('term_id', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.parent.ward-results');
    }
}