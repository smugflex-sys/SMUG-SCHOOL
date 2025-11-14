<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($student)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Welcome & Profile Widget -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Hello, {{ Auth::user()->name }}!</h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Welcome to your personal dashboard.</p>
                            <div class="mt-4 grid grid-cols-2 gap-4 text-sm border-t dark:border-gray-700 pt-4">
                                <div>
                                    <p class="text-gray-500">Admission No:</p>
                                    <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $student->admission_no }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Class:</p>
                                    <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $student->schoolClass->name }} {{ $student->classArm->name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Stats Widget -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                                <h3 class="text-gray-500 text-sm font-medium">Term Attendance</h3>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $attendancePercentage }}%</p>
                            </div>
                             <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                                <h3 class="text-gray-500 text-sm font-medium">Outstanding Invoices</h3>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $outstandingInvoices }}</p>
                            </div>
                        </div>

                        <!-- Recent Results Chart Widget -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Recent Performance (Average %)</h3>
                            <div style="height: 300px;">
                                <canvas id="resultsChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- My Subjects Widget -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">My Subjects</h3>
                            <ul class="space-y-3">
                                @forelse($subjects as $subject)
                                    <li class="flex items-center p-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                                        <span class="text-green-600 dark:text-green-400">&#10003;</span>
                                        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $subject->name }}</span>
                                    </li>
                                @empty
                                    <p class="text-sm text-gray-500">No subjects assigned yet.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                <!-- This block will now show if no student record is found -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Student Record Not Found</h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Your user account has the "Student" role, but it is not linked to a specific student record in the system.
                        <br>
                        Please contact the school administration to have this corrected.
                    </p>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            @if ($student)
            const ctx = document.getElementById('resultsChart').getContext('2d');
            let chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Average Score',
                        data: [],
                        backgroundColor: 'rgba(22, 163, 74, 0.2)',
                        borderColor: 'rgba(22, 163, 74, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });

            Livewire.on('updateResultsChart', ({ data }) => {
                chart.data.labels = data.labels;
                chart.data.datasets[0].data = data.data;
                chart.update();
            });
            @endif
        });
    </script>
    @endpush
</div>