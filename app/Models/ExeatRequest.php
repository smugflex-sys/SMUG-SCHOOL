<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExeatRequest extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'user_id', 'reason', 'departure_time', 'expected_return_time', 'status', 'admin_remarks', 'approved_by', 'token'];
    protected $casts = ['departure_time' => 'datetime', 'expected_return_time' => 'datetime'];

    public function student() { return $this->belongsTo(Student::class); }
    public function parent() { return $this->belongsTo(User::class, 'user_id'); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }
}