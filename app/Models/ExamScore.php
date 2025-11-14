<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamScore extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'term_id', 'subject_id', 'exam_type_id', 'score'];
}