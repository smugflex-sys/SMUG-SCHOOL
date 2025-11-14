<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\ClassArm;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class ManageStudents extends Component
{
    use WithPagination;

    // User fields
    public $name, $email;
    // Student fields
    public $admission_no, $school_class_id, $class_arm_id, $date_of_birth, $gender;

    public $studentId, $userId;
    public $showModal = false;
    public $isEditMode = false;
    public $search = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'admission_no' => 'required|string|unique:students,admission_no,' . $this->studentId,
            'school_class_id' => 'required|exists:school_classes,id',
            'class_arm_id' => 'required|exists:class_arms,id',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
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

        // Create User
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make('password'), // Default password
        ]);
        $user->assignRole('Student');

        // Create Student
        Student::create([
            'user_id' => $user->id,
            'admission_no' => $this->admission_no,
            'school_class_id' => $this->school_class_id,
            'class_arm_id' => $this->class_arm_id,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
        ]);

        session()->flash('message', 'Student admitted successfully.');
        $this->closeModal();
    }

    public function edit($studentId)
    {
        $student = Student::with('user')->findOrFail($studentId);
        $this->studentId = $studentId;
        $this->userId = $student->user_id;
        $this->name = $student->user->name;
        $this->email = $student->user->email;
        $this->admission_no = $student->admission_no;
        $this->school_class_id = $student->school_class_id;
        $this->class_arm_id = $student->class_arm_id;
        $this->date_of_birth = $student->date_of_birth;
        $this->gender = $student->gender;
        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $student = Student::findOrFail($this->studentId);
        $student->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $student->update([
            'admission_no' => $this->admission_no,
            'school_class_id' => $this->school_class_id,
            'class_arm_id' => $this->class_arm_id,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
        ]);

        session()->flash('message', 'Student record updated successfully.');
        $this->closeModal();
    }

    public function delete($studentId)
    {
        $student = Student::findOrFail($studentId);
        // This will also delete the student record due to cascade on delete
        $student->user()->delete();
        session()->flash('message', 'Student deleted successfully.');
    }

    public function render()
    {
        $students = Student::with(['user', 'schoolClass', 'classArm'])
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhere('admission_no', 'like', '%' . $this->search . '%')
            ->latest()->paginate(10);

        return view('livewire.admin.manage-students', [
            'students' => $students,
            'schoolClasses' => SchoolClass::all(),
            'classArms' => ClassArm::all(),
        ]);
    }
}