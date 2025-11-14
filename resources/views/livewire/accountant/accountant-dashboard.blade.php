<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Accountant Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-gray-500 text-sm font-medium">Revenue (Active Term)</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">₦{{ number_format($revenueThisTerm, 2) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-gray-500 text-sm font-medium">Total Outstanding Fees</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">₦{{ number_format($outstandingFees, 2) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg flex flex-col justify-center items-center space-y-2">
                     <a href="{{ route('accountant.fees.index') }}" class="w-full text-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">Manage Fees</a>
                     <a href="{{ route('accountant.invoices.index') }}" class="w-full text-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">Manage Invoices</a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                <!-- Recent Payments -->
                <div class="lg:col-span-3 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Recent Payments</h3>
                    <div class="space-y-4">
                        @forelse($recentPayments as $payment)
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $payment->invoice->student->user->name }}</p>
                                    <p class="text-xs text-gray-500">Ref: {{ $payment->reference }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-green-600">₦{{ number_format($payment->amount, 2) }}</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($payment->payment_date)->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">No recent payments found.</p>
                        @endforelse
                    </div>
                </div>
                <!-- Invoice Status Chart -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Invoice Status (Active Term)</h3>
                    <div style="height: 250px;">
                        <canvas id="invoiceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            const ctx = document.getElementById('invoiceChart').getContext('2d');
            let chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        backgroundColor: [
                            'rgba(22, 163, 74, 0.7)', // Green
                            'rgba(220, 38, 38, 0.7)',  // Red
                            'rgba(234, 179, 8, 0.7)'   // Yellow
                        ],
                        borderColor: [
                            'rgba(22, 163, 74, 1)',
                            'rgba(220, 38, 38, 1)',
                            'rgba(234, 179, 8, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            Livewire.on('updateInvoiceChart', ({ data }) => {
                chart.data.labels = data.labels;
                chart.data.datasets[0].data = data.data;
                chart.update();
            });
        });
    </script>
    @endpush
</div>