<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        // Load all necessary relationships for the view
        $invoice->load('student.user', 'student.parents', 'term.session', 'items');
        $schoolSettings = Setting::pluck('value', 'key');

        return view('accountant.invoices.show', compact('invoice', 'schoolSettings'));
    }

    /**
     * Download the specified invoice as a PDF.
     */
    public function download(Invoice $invoice)
    {
        $invoice->load('student.user', 'student.parents', 'term.session', 'items');
        $schoolSettings = Setting::pluck('value', 'key');

        $data = [
            'invoice' => $invoice,
            'schoolSettings' => $schoolSettings,
        ];

        $pdf = Pdf::loadView('reports.invoice-pdf', $data);

        // Set a user-friendly filename for the download
        $fileName = 'invoice-' . $invoice->invoice_number . '.pdf';

        return $pdf->stream($fileName);
    }
}