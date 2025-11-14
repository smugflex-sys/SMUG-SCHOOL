<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class CbtAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'cbt_attempt_id',
        'cbt_question_id',
        'selected_option',
        'is_correct',
    ];

    /**
     * Get the question that this answer belongs to.
     * THIS IS THE NEW METHOD THAT FIXES THE ERROR.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(CbtQuestion::class, 'cbt_question_id');
    }
}