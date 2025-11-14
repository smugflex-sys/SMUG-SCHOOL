<?php

namespace App\Livewire\Accountant;

use App\Models\Session as AcademicSession; // <-- THIS IS THE FIX: Use the correct Session model and alias it
use App\Models\Invoice;
use App\Models\Payment;
use Livewire\Component;

class AccountantDashboard extends Component
{
    public $revenueThisTerm = 0;
    public $outstandingFees = 0;
    public $recentPayments = [];
    public $invoiceStats = [];

    public function mount()
    {
        $activeSession = AcademicSession::where('is_active', true)->first();

        if ($activeSession) {
            // Get all term IDs for the active session
            $termIds = $activeSession->terms()->pluck('id');

            // Calculate revenue for the active term(s)
            $this->revenueThisTerm = Payment::whereHas('invoice', function ($query) use ($termIds) {
                $query->whereIn('term_id', $termIds);
            })->sum('amount');

            // Calculate total outstanding fees
            $this->outstandingFees = Invoice::where('status', '!=', 'paid')->sum(\DB::raw('total_amount - amount_paid'));

            // Get recent payments
            $this->recentPayments = Payment::with('invoice.student.user')
                ->latest('payment_date')
                ->limit(5)
                ->get();

            // Get invoice stats for the chart
            $paidCount = Invoice::whereIn('term_id', $termIds)->where('status', 'paid')->count();
            $unpaidCount = Invoice::whereIn('term_id', $termIds)->where('status', 'unpaid')->count();
            $partialCount = Invoice::whereIn('term_id', $termIds)->where('status', 'partially_paid')->count();

            $this->invoiceStats = [
                'labels' => ['Paid', 'Unpaid', 'Partially Paid'],
                'data' => [$paidCount, $unpaidCount, $partialCount],
            ];

            $this->dispatch('updateInvoiceChart', ['data' => $this->invoiceStats]);
        }
    }

    public function render()
    {
        return view('livewire.accountant.accountant-dashboard');
    }
}