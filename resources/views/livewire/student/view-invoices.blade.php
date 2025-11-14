<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Invoices') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-4">
                @forelse($invoices as $invoice)
                    <div class="p-4 border rounded-lg flex flex-col md:flex-row justify-between items-center">
                        <div class="flex-grow">
                            <div class="flex justify-between items-center">
                                <p class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $invoice->invoice_number }}</p>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($invoice->status == 'paid') bg-green-100 text-green-800 @endif
                                    @if($invoice->status == 'unpaid') bg-red-100 text-red-800 @endif
                                    @if($invoice->status == 'partially_paid') bg-yellow-100 text-yellow-800 @endif
                                ">
                                    {{ Str::title(str_replace('_', ' ', $invoice->status)) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Term: {{ $invoice->term->name }} ({{ $invoice->term->academicSession->name }})</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Amount: ₦{{ number_format($invoice->total_amount, 2) }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Amount Paid: ₦{{ number_format($invoice->amount_paid, 2) }}</p>
                            <p class="font-semibold text-gray-800 dark:text-gray-200">Amount Due: ₦{{ number_format($invoice->total_amount - $invoice->amount_paid, 2) }}</p>
                        </div>
                        <div class="mt-4 md:mt-0 md:ml-6">
                            @if($invoice->status != 'paid')
                                <form method="POST" action="{{ route('payment.pay') }}">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                    <input type="hidden" name="amount" value="{{ ($invoice->total_amount - $invoice->amount_paid) * 100 }}"> {{-- Amount in kobo --}}
                                    <x-button type="submit">Pay Now</x-button>
                                </form>
                            @else
                                <x-secondary-button disabled>Paid in Full</x-secondary-button>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">You have no invoices.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>