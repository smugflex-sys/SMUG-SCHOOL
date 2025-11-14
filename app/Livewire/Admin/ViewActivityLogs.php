<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class ViewActivityLogs extends Component
{
    use WithPagination;

    public $selectedLogName = '';
    public $selectedCauserId = '';
    public $logNames = [];
    public $users = [];

    public function mount()
    {
        // Get distinct log names (model names) from the activity log table
        $this->logNames = Activity::select('log_name')->distinct()->pluck('log_name');
        // Get all users who can cause activities
        $this->users = User::all();
    }

    public function updatingSelectedLogName()
    {
        $this->resetPage();
    }

    public function updatingSelectedCauserId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $logs = Activity::with(['causer', 'subject'])
            ->when($this->selectedLogName, function ($query) {
                $query->where('log_name', $this->selectedLogName);
            })
            ->when($this->selectedCauserId, function ($query) {
                $query->where('causer_id', $this->selectedCauserId);
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin.view-activity-logs', [
            'logs' => $logs,
        ]);
    }
}