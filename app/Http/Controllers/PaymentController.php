<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaystackService;
use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // <-- Make sure Auth is imported

class PaymentController extends Controller
{
    protected $paystackService;

    public function __construct(PaystackService $paystackService)
    {
        $this->paystackService = $paystackService;
    }

    public function redirectToGateway(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric',
            'invoice_id' => 'required|exists:invoices,id',
        ]);

        // --- THIS IS THE START OF THE FIX ---

        // 1. Find the invoice that is being paid.
        $invoice = Invoice::findOrFail($request->invoice_id);

        // 2. CRITICAL SECURITY CHECK: Ensure the logged-in parent is authorized to pay for this invoice.
        $authorizedStudentIds = Auth::user()->children->pluck('id');
        if (!$authorizedStudentIds->contains($invoice->student_id)) {
            // If the invoice does not belong to one of their children, deny access.
            abort(403, 'UNAUTHORIZED ACTION.');
        }

        // 3. Get the correct student ID from the invoice itself.
        $studentId = $invoice->student_id;

        // --- THIS IS THE END OF THE FIX ---

        $data = [
            'email' => $request->email,
            'amount' => $request->amount, // Amount is already in kobo from the form
            'callback_url' => route('payment.callback'),
            'metadata' => [
                'invoice_id' => $request->invoice_id,
                'student_id' => $studentId, // <-- Use the corrected student ID
            ]
        ];

        $transaction = $this->paystackService->initializeTransaction($data);

        if ($transaction && isset($transaction['authorization_url'])) {
            return redirect($transaction['authorization_url']);
        }

        return back()->with('error', 'Could not initiate payment. Please try again.');
    }

    public function handleGatewayCallback(Request $request)
    {
        $reference = $request->query('reference');

        $paymentDetails = $this->paystackService->verifyTransaction($reference);

        if ($paymentDetails && $paymentDetails['status'] === 'success') {
            $invoiceId = $paymentDetails['metadata']['invoice_id'];
            $amountPaid = $paymentDetails['amount'] / 100; // Convert from kobo

            $invoice = Invoice::findOrFail($invoiceId);

            // Prevent duplicate processing
            if (Payment::where('reference', $reference)->exists()) {
                return redirect()->route('parent.payments')->with('message', 'Payment already processed.');
            }

            // Create a payment record
            Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $amountPaid,
                'payment_method' => 'Paystack',
                'reference' => $reference,
                'payment_date' => Carbon::parse($paymentDetails['paid_at']),
            ]);

            // Update the invoice
            $invoice->amount_paid += $amountPaid;
            if ($invoice->amount_paid >= $invoice->total_amount) {
                $invoice->status = 'paid';
            } else {
                $invoice->status = 'partially_paid';
            }
            $invoice->save();

            return redirect()->route('parent.payments')->with('message', 'Payment successful!');
        }

        return redirect()->route('parent.payments')->with('error', 'Payment verification failed. Please contact support.');
    }
}