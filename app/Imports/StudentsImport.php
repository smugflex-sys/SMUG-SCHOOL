<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    private $school_class_id;
    private $class_arm_id;

    public function __construct(int $school_class_id, int $class_arm_id)
    {
        $this->school_class_id = $school_class_id;
        $this->class_arm_id = $class_arm_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Create the User account
        $user = User::create([
            'name'     => $row['full_name'],
            'email'    => $row['email'],
            'password' => Hash::make('password'), // Default password
        ]);

        $user->assignRole('Student');

        // Create the Student record
        return new Student([
            'user_id'         => $user->id,
            'admission_no'    => $row['admission_number'],
            'school_class_id' => $this->school_class_id,
            'class_arm_id'    => $this->class_arm_id,
            'gender'          => $row['gender'],
            'date_of_birth'   => $row['date_of_birth'],
        ]);
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'admission_number' => 'required|string|unique:students,admission_no',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'required|date',
        ];
    }
}