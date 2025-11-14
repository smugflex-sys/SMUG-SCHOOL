<?php

namespace App\Livewire\Admin;

use App\Models\Session; // Use the original Session model
use App\Models\Term;
use Livewire\Component;
use Livewire\WithPagination;

class ManageSessions extends Component
{
    use WithPagination;

    // Properties for Session
    public $name, $is_active;
    public $sessionId;
    public $showSessionModal = false;
    public $isSessionEditMode = false;

    // Properties for Term
    public $term_name;
    public $start_date, $end_date;
    public $selectedSessionIdForTerm;
    public $showTermModal = false;

    protected function sessionRules()
    {
        return [
            'name' => 'required|string|unique:academic_sessions,name,' . $this->sessionId,
        ];
    }

    protected function termRules()
    {
        return [
            'term_name' => 'required|in:First Term,Second Term,Third Term',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'selectedSessionIdForTerm' => 'required|exists:academic_sessions,id',
        ];
    }
    
    // --- SESSION MANAGEMENT ---
    public function openSessionModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'sessionId', 'isSessionEditMode']);
        $this->showSessionModal = true;
    }

    public function storeSession()
    {
        $this->validate($this->sessionRules());
        Session::create(['name' => $this->name]);
        session()->flash('message', 'Academic Session created successfully.');
        $this->showSessionModal = false;
    }
    // ... Add edit, update, delete for Session ...

    // --- TERM MANAGEMENT ---
    public function openTermModal($sessionId)
    {
        $this->resetValidation();
        $this->reset(['term_name', 'start_date', 'end_date']);
        $this->selectedSessionIdForTerm = $sessionId;
        $this->showTermModal = true;
    }

    public function storeTerm()
    {
        $this->validate($this->termRules());

        Term::create([
            'academic_session_id' => $this->selectedSessionIdForTerm,
            'name' => $this->term_name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
        
        session()->flash('message', 'Term created and scheduled successfully.');
        $this->showTermModal = false;
    }

    public function render()
    {
        return view('livewire.admin.manage-sessions', [
            'sessions' => Session::with('terms')->latest()->paginate(5),
        ]);
    }
}