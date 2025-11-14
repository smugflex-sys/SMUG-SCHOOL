<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Invoice Details') }}
            </h2>
            <!-- THIS IS THE NEW DOWNLOAD BUTTON -->
            <a href="{{ route('accountant.invoices.download', $invoice) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Download PDF
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8" id="invoice-content">
                <!-- School Header -->
                <div class="flex justify-between items-start pb-4 border-b dark:border-gray-700">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $schoolSettings['school_name'] ?? 'GreenField High School' }}</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $schoolSettings['school_address'] ?? '123 Education Way, Ikeja, Lagos' }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $schoolSettings['school_email'] ?? 'info@school.com' }}</p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-3xl font-bold uppercase text-gray-400 dark:text-gray-500">Invoice</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">#{{ $invoice->invoice_number }}</p>
                    </div>
                </div>

                <!-- Billing Info -->
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div>
                        <h4 class="font-semibold text-gray-700 dark:text-gray-300">Bill To:</h4>
                        <p class="text-gray-900 dark:text-gray-100 font-bold">{{ $invoice->student->user->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Parent: {{ $invoice->student->parents->first()->name ?? 'N/A' }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Class: {{ $invoice->student->schoolClass->name }} {{ $invoice->student->classArm->name }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Invoice Date:</strong> {{ $invoice->created_at->format('M d, Y') }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
                        <p class="text-sm font-bold mt-2"><strong>Term:</strong> {{ $invoice->term->name }} ({{ $invoice->term->session->name }})</p>
                    </div>
                </div>

                <!-- Invoice Items Table -->
                <div class="mt-8 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Item Description</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($invoice->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $item->item_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-600 dark:text-gray-400">₦{{ number_format($item->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Invoice Totals -->
                <div class="flex justify-end mt-6">
                    <div class="w-full max-w-xs space-y-2">
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>Subtotal:</span>
                            <span>₦{{ number_format($invoice->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>Amount Paid:</span>
                            <span>- ₦{{ number_format($invoice->amount_paid, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg text-gray-900 dark:text-gray-100 border-t dark:border-gray-700 pt-2">
                            <span>Balance Due:</span>
                            <span>₦{{ number_format($invoice->total_amount - $invoice->amount_paid, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>