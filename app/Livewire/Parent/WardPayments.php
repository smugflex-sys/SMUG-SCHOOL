<?php

namespace App\Livewire\Parent;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WardPayments extends Component
{
    public $wardsWithInvoices;

    public function mount()
    {
        $wardIds = Auth::user()->children()->pluck('students.id');
        
        $this->wardsWithInvoices = Auth::user()->children()->with(['user', 'invoices' => function ($query) {
            $query->with('term.academicSession')->orderBy('term_id', 'desc');
        }])->get();
    }

    public function render()
    {
        return view('livewire.parent.ward-payments');
    }
}