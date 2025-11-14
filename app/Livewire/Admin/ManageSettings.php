<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use App\Models\Session as AcademicSession; // Import the Session model and alias it for clarity
use Livewire\Component;

class ManageSettings extends Component
{
    public $settings = [];
    public $schoolName, $schoolAddress, $schoolEmail, $schoolPhone, $activeSessionId;

    public function mount()
    {
        $this->settings = Setting::pluck('value', 'key')->toArray();
        $this->schoolName = $this->settings['school_name'] ?? '';
        $this->schoolAddress = $this->settings['school_address'] ?? '';
        $this->schoolEmail = $this->settings['school_email'] ?? '';
        $this->schoolPhone = $this->settings['school_phone'] ?? '';
        $this->activeSessionId = $this->settings['active_session_id'] ?? '';
    }

    public function saveSettings()
    {
        $this->validate([
            'schoolName' => 'required|string',
            'activeSessionId' => 'required|exists:academic_sessions,id', // Validate against the correct table
        ]);

        Setting::updateOrCreate(['key' => 'school_name'], ['value' => $this->schoolName]);
        Setting::updateOrCreate(['key' => 'school_address'], ['value' => $this->schoolAddress]);
        Setting::updateOrCreate(['key' => 'school_email'], ['value' => $this->schoolEmail]);
        Setting::updateOrCreate(['key' => 'school_phone'], ['value' => $this->schoolPhone]);
        Setting::updateOrCreate(['key' => 'active_session_id'], ['value' => $this->activeSessionId]);

        // Set the chosen session to active and others to inactive
        AcademicSession::where('id', $this->activeSessionId)->update(['is_active' => true]);
        AcademicSession::where('id', '!=', $this->activeSessionId)->update(['is_active' => false]);

        session()->flash('message', 'Settings saved successfully.');
    }

    public function render()
    {
        return view('livewire.admin.manage-settings', [
            'academicSessions' => AcademicSession::all(), // Use the aliased model
        ]);
    }
}