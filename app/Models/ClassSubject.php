<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClassSubject extends Pivot
{
    protected $table = 'class_subject';

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class, 'class_subject_teacher', 'class_subject_id', 'staff_id');
    }
}