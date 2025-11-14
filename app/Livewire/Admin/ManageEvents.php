<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;

class ManageEvents extends Component
{
    use WithPagination;

    public $title, $description, $start_time, $end_time;
    public $eventId;
    public $showModal = false;
    public $isEditMode = false;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
        ];
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {
        $this->validate();

        Event::create([
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        session()->flash('message', 'Event created successfully and added to the calendar.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $this->eventId = $id;
        $this->title = $event->title;
        $this->description = $event->description;
        // Format for datetime-local input
        $this->start_time = $event->start_time->format('Y-m-d\TH:i');
        $this->end_time = $event->end_time ? $event->end_time->format('Y-m-d\TH:i') : null;
        
        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $event = Event::findOrFail($this->eventId);
        $event->update([
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        session()->flash('message', 'Event updated successfully.');
        $this->closeModal();
    }

    public function delete($id)
    {
        Event::findOrFail($id)->delete();
        session()->flash('message', 'Event deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.manage-events', [
            'events' => Event::orderBy('start_time', 'desc')->paginate(10),
        ]);
    }
}