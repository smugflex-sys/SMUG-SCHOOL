<?php

namespace App\Livewire\Shared;

use App\Models\Event;
use Carbon\Carbon;
use App\Models\Term;
use Livewire\Component;

class ViewCalendar extends Component
{
    public $currentMonth;
    public $currentYear;
    public $daysInMonth;
    public $startOfMonth;
    public $events;
     public $terms = []; 

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadCalendar();
    }

    public function loadCalendar()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $this->daysInMonth = $date->daysInMonth;
        $this->startOfMonth = $date->dayOfWeek; // 0=Sun, 1=Mon, ...

        $this->events = Event::whereMonth('start_time', $this->currentMonth)
            ->whereYear('start_time', $this->currentYear)
            ->get()
            ->groupBy(function ($event) {
                return $event->start_time->day;
            });

         $this->terms = Term::where(function ($query) {
                // Term starts this month
                $query->whereYear('start_date', $this->currentYear)->whereMonth('start_date', $this->currentMonth);
            })->orWhere(function ($query) {
                // Term ends this month
                $query->whereYear('end_date', $this->currentYear)->whereMonth('end_date', $this->currentMonth);
            })->orWhere(function ($query) {
                // Term spans across the entire month
                $query->where('start_date', '<=', Carbon::create($this->currentYear, $this->currentMonth, 1))
                      ->where('end_date', '>=', Carbon::create($this->currentYear, $this->currentMonth, 1)->endOfMonth());
            })->get();
    }

    public function goToPreviousMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadCalendar();
    }

    public function goToNextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadCalendar();
    }

    public function render()
    {
        return view('livewire.shared.view-calendar');
    }
}