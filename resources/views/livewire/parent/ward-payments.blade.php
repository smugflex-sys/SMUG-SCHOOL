<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Fee Payments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-8">
                @foreach($wardsWithInvoices as $ward)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 border-b dark:border-gray-700 pb-2 mb-4">
                            Invoices for {{ $ward->user->name }}
                        </h3>
                        <div class="space-y-4">
                            @forelse($ward->invoices as $invoice)
                                <div class="p-4 border dark:border-gray-700 rounded-lg flex flex-col md:flex-row justify-between items-center">
                                    <div>
                                        <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $invoice->invoice_number }} - {{ $invoice->term->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Total: ₦{{ number_format($invoice->total_amount, 2) }} | Paid: ₦{{ number_format($invoice->amount_paid, 2) }}</p>
                                        <p class="font-bold text-red-600">Due: ₦{{ number_format($invoice->total_amount - $invoice->amount_paid, 2) }}</p>
                                    </div>
                                    <div class="mt-4 md:mt-0">
                                        @if($invoice->status != 'paid')
                                            <form method="POST" action="{{ route('payment.pay') }}">
                                                @csrf
                                                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                                <input type="hidden" name="amount" value="{{ ($invoice->total_amount - $invoice->amount_paid) * 100 }}">
                                                <x-button type="submit">Pay Now</x-button>
                                            </form>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Paid in Full</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">No invoices found for this ward.</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>