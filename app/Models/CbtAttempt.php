<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\HasMany;

class CbtAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'cbt_exam_id',
        'student_id',
        'start_time',
        'end_time',
        'score',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the exam that this attempt belongs to.
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(CbtExam::class, 'cbt_exam_id');
    }
    
    /**
     * Get the student that this attempt belongs to.
     * THIS IS THE NEW METHOD THAT FIXES THE ERROR.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get all of the answers for the attempt.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(CbtAnswer::class);
    }
}