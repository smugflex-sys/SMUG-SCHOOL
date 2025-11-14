<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;

class WebhookController extends Controller
{
    /**
     * Handle incoming Paystack webhooks.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function handlePaystackWebhook(Request $request)
    {
        // 1. CRITICAL: Verify the webhook signature to ensure it's from Paystack
        $paystackSecret = config('app.paystack_secret_key');
        if (!$request->header('x-paystack-signature') || 
            ($request->header('x-paystack-signature') !== hash_hmac('sha512', $request->getContent(), $paystackSecret))) {
            
            // Deny access if the signature is invalid
            abort(403, 'Invalid Webhook Signature');
        }

        // 2. Decode the incoming event payload
        $event = json_decode($request->getContent());

        // 3. Handle only the 'charge.success' event
        if ($event->event === 'charge.success') {
            $paymentData = $event->data;
            $reference = $paymentData->reference;
            
            // 4. IMPORTANT: Check if we've already processed this transaction
            if (Payment::where('reference', $reference)->exists()) {
                // If we have, just acknowledge receipt to Paystack and do nothing else.
                return response()->json(['status' => 'success'], 200);
            }

            // 5. If not processed, get the details and update the database
            $invoiceId = $paymentData->metadata->invoice_id;
            $amountPaid = $paymentData->amount / 100; // Convert from kobo

            $invoice = Invoice::findOrFail($invoiceId);

            // Create a payment record
            Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $amountPaid,
                'payment_method' => 'Paystack (Webhook)', // Note the source
                'reference' => $reference,
                'payment_date' => Carbon::parse($paymentData->paid_at),
            ]);

            // Update the invoice status
            $invoice->amount_paid += $amountPaid;
            if ($invoice->amount_paid >= $invoice->total_amount) {
                $invoice->status = 'paid';
            } else {
                $invoice->status = 'partially_paid';
            }
            $invoice->save();
        }
        
        // 6. Acknowledge receipt of the event to Paystack
        return response()->json(['status' => 'success'], 200);
    }
}