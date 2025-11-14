<?php

namespace App\Livewire\Student;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewInvoices extends Component
{
    public function render()
    {
        $studentId = Auth::user()->student->id;
        $invoices = Invoice::with('term.academicSession')
            ->where('student_id', $studentId)
            ->latest()
            ->get();

        return view('livewire.student.view-invoices', [
            'invoices' => $invoices,
        ]);
    }
}