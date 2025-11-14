<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CbtExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subject_id',
        'school_class_id',
        'duration_minutes',
        'instructions',
        'available_from',
        'available_to',
    ];

    protected $casts = [
        'available_from' => 'datetime',
        'available_to' => 'datetime',
    ];

    /**
     * Get the subject that this exam belongs to.
     * THIS IS THE NEW METHOD THAT FIXES THE ERROR.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the class that this exam is for.
     * THIS IS THE OTHER NEW METHOD THAT FIXES THE ERROR.
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    /**
     * The questions that belong to the exam.
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(CbtQuestion::class, 'cbt_exam_question');
    }
}