<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Staff;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class ManageStaff extends Component
{
    use WithPagination;

    // User fields
    public $name, $email;
    // Staff fields
    public $staff_no, $designation, $role_id;

    public $staffId, $userId;
    public $showModal = false;
    public $isEditMode = false;
    public $search = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'staff_no' => 'required|string|unique:staff,staff_no,' . $this->staffId,
            'designation' => 'required|string',
            'role_id' => 'required|exists:roles,id',
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

        $role = Role::findById($this->role_id);

        // Create User
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make('password'), // Default password
        ]);
        $user->assignRole($role->name);

        // Create Staff
        Staff::create([
            'user_id' => $user->id,
            'staff_no' => $this->staff_no,
            'designation' => $this->designation,
        ]);

        session()->flash('message', 'Staff created successfully.');
        $this->closeModal();
    }
    
    // Implement edit, update, and delete methods similarly...

    public function render()
    {
        $staff = Staff::with('user.roles')
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()->paginate(10);
            
        // Exclude Student and Parent roles from the list of assignable roles
        $roles = Role::whereNotIn('name', ['Student', 'Parent'])->get();

        return view('livewire.admin.manage-staff', [
            'staffMembers' => $staff,
            'roles' => $roles,
        ]);
    }
}