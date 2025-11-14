<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class ManageParents extends Component
{
    use WithPagination;

    public $name, $email;
    public $selectedChildren = [];
    public $userId; // The ID of the parent user we are editing
    public $showModal = false;
    public $isEditMode = false;

    // We make the rules a function to handle unique email validation during updates
    protected function rules() {
        return [
            'name' => 'required|string|max:255',
            // This rule ensures the email is unique, EXCEPT for the current user being edited
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'selectedChildren' => 'sometimes|array', // 'sometimes' makes it not required on every validation check
        ];
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(); // Resets all public properties
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'selectedChildren' => 'required|array|min:1',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make('password'), // Default password
        ]);
        $user->assignRole('Parent');

        $user->children()->sync($this->selectedChildren);

        session()->flash('message', 'Parent account created and linked successfully.');
        $this->showModal = false;
    }
    
    // --- NEW: Edit and Update Methods ---
    public function edit($userId)
    {
        $this->resetValidation();
        $user = User::with('children')->findOrFail($userId);
        
        $this->userId = $userId;
        $this->name = $user->name;
        $this->email = $user->email;
        // Load the IDs of the currently linked children into the array
        $this->selectedChildren = $user->children->pluck('id')->toArray();

        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);
        
        // Sync the linked children, this adds new ones and removes un-checked ones
        $user->children()->sync($this->selectedChildren);

        session()->flash('message', 'Parent record updated successfully.');
        $this->showModal = false;
    }

    // --- NEW: Delete Method ---
    public function delete($userId)
    {
        $user = User::findOrFail($userId);
        // Deleting the user will also automatically detach the records in the pivot table
        $user->delete();
        session()->flash('message', 'Parent account deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.manage-parents', [
            'parents' => User::role('Parent')->with('children.user')->latest()->paginate(10),
            'allStudents' => Student::with('user')->get(),
        ]);
    }
}