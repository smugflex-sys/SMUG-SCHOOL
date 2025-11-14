<div>
    
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('School Analytics & Insights') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Subject Performance Chart -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Overall Subject Performance (Average Score)</h3>
                    <div style="height: 400px;"><canvas id="subjectChart"></canvas></div>
                </div>
                <!-- Financial Summary Chart -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Financial Summary (All Time)</h3>
                    <div style="height: 400px;"><canvas id="financialChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            // Subject Chart
            const subjectCtx = document.getElementById('subjectChart').getContext('2d');
            const subjectChart = new Chart(subjectCtx, { /* ... Chart config ... */ });
            Livewire.on('updateSubjectChart', ({ data }) => {
                subjectChart.data.labels = Object.keys(data);
                subjectChart.data.datasets[0].data = Object.values(data);
                subjectChart.update();
            });

            // Financial Chart
            const financialCtx = document.getElementById('financialChart').getContext('2d');
            const financialChart = new Chart(financialCtx, { /* ... Chart config for Pie Chart ... */ });
            Livewire.on('updateFinancialChart', ({ data }) => {
                financialChart.data.labels = data.labels;
                financialChart.data.datasets[0].data = data.data;
                financialChart.update();
            });
        });
    </script>
    @endpush
</div>
