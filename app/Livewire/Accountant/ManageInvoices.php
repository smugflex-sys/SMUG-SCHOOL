<?php

namespace App\Livewire\Accountant;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\FeeStructure;
use App\Models\SchoolClass;
use App\Models\Term;
use App\Models\Student;
use Carbon\Carbon;
use Livewire\Component;

class ManageInvoices extends Component
{
    public $selectedClassId, $selectedTermId;
    public $generationMessage = '';

    public function generateInvoices()
    {
        $this->validate([
            'selectedClassId' => 'required|exists:school_classes,id',
            'selectedTermId' => 'required|exists:terms,id',
        ]);

        $feeStructures = FeeStructure::where('school_class_id', $this->selectedClassId)->get();
        if ($feeStructures->isEmpty()) {
            $this->generationMessage = 'Error: No fee structure found for the selected class.';
            return;
        }

        $students = Student::where('school_class_id', $this->selectedClassId)->get();
        $totalAmount = $feeStructures->sum('amount');
        $count = 0;

        foreach ($students as $student) {
            // Check if an invoice already exists for this student and term
            $existingInvoice = Invoice::where('student_id', $student->id)
                ->where('term_id', $this->selectedTermId)
                ->exists();

            if (!$existingInvoice) {
                $invoice = Invoice::create([
                    'invoice_number' => 'INV-' . time() . '-' . $student->id,
                    'student_id' => $student->id,
                    'term_id' => $this->selectedTermId,
                    'total_amount' => $totalAmount,
                    'due_date' => Carbon::now()->addWeeks(2)->format('Y-m-d'),
                ]);

                foreach ($feeStructures as $structure) {
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'item_name' => $structure->feeType->name,
                        'amount' => $structure->amount,
                    ]);
                }
                $count++;
            }
        }

        $this->generationMessage = "Success: Generated {$count} new invoices for the selected class and term.";
    }

    public function render()
    {
        return view('livewire.accountant.manage-invoices', [
            'invoices' => Invoice::with('student.user', 'term')->latest()->paginate(10),
            'schoolClasses' => SchoolClass::all(),
            'terms' => Term::with('academicSession')->get(),
        ]);
    }
}