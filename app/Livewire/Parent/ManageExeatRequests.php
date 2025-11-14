<?php

namespace App\Livewire\Parent;

use App\Models\ExeatRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class ManageExeatRequests extends Component
{
    public $wards = [];
    public $student_id, $reason, $departure_time, $expected_return_time;
    public $showModal = false;

    public function mount()
    {
        $this->wards = Auth::user()->children()->with('user')->get();
    }

    protected $rules = [
        'student_id' => 'required|exists:students,id',
        'reason' => 'required|string|min:10',
        'departure_time' => 'required|date',
        'expected_return_time' => 'required|date|after:departure_time',
    ];

    public function openModal()
    {
        $this->reset();
        $this->wards = Auth::user()->children()->with('user')->get();
        $this->showModal = true;
    }

    public function submitRequest()
    {
        $this->validate();

        ExeatRequest::create([
            'student_id' => $this->student_id,
            'user_id' => Auth::id(),
            'reason' => $this->reason,
            'departure_time' => $this->departure_time,
            'expected_return_time' => $this->expected_return_time,
            'token' => Str::random(32),
        ]);

        session()->flash('message', 'Exeat request submitted successfully. Awaiting approval.');
        $this->showModal = false;
    }

    public function render()
    {
        $wardIds = $this->wards->pluck('id');
        $requests = ExeatRequest::whereIn('student_id', $wardIds)->with('student.user')->latest()->get();
        return view('livewire.parent.manage-exeat-requests', compact('requests'));
    }
}