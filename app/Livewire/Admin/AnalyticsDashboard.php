<?php

    namespace App\Livewire\Admin;

    use App\Models\Subject;
    use App\Models\ExamScore;
    use App\Models\Invoice;
    use Livewire\Component;

    class AnalyticsDashboard extends Component
    {
        public $subjectPerformance = [];
        public $financialSummary = [];

        public function mount()
        {
            // --- Subject Performance Analysis ---
            $this->subjectPerformance = Subject::withAvg('scores', 'score')
                ->get()
                ->sortByDesc('scores_avg')
                ->mapWithKeys(function ($subject) {
                    return [$subject->name => round($subject->scores_avg, 2)];
                })
                ->toArray();

            // --- Financial Summary Analysis ---
            $totalBilled = Invoice::sum('total_amount');
            $totalPaid = Invoice::sum('amount_paid');
            $totalOutstanding = $totalBilled - $totalPaid;
            $this->financialSummary = [
                'labels' => ['Paid', 'Outstanding'],
                'data' => [$totalPaid, $totalOutstanding],
            ];

            // Dispatch events to update charts in the view
            $this->dispatch('updateSubjectChart', ['data' => $this->subjectPerformance]);
            $this->dispatch('updateFinancialChart', ['data' => $this->financialSummary]);
        }

        public function render()
        {
            return view('livewire.admin.analytics-dashboard');
        }
    }