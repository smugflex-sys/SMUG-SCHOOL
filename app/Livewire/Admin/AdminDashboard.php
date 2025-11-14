<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use App\Models\Staff;
use App\Models\Invoice;
use App\Models\BookIssue;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminDashboard extends Component
{
    public $totalStudents;
    public $totalStaff;
    public $totalRevenue;
    public $booksIssued;
    public $studentsPerClass = [];

    public function mount()
    {
        $this->totalStudents = Student::count();
        $this->totalStaff = Staff::count();
        $this->totalRevenue = Invoice::sum('amount_paid');
        $this->booksIssued = BookIssue::where('status', 'issued')->count();

        $this->studentsPerClass = Student::join('school_classes', 'students.school_class_id', '=', 'school_classes.id')
            ->select('school_classes.name', DB::raw('count(*) as total'))
            ->groupBy('school_classes.name')
            ->get()
            ->pluck('total', 'name')
            ->toArray();
            
        // Dispatch the data to the browser for Chart.js
        $this->dispatch('updateChart', ['data' => $this->studentsPerClass]);
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}