<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Term extends Model
{
    use HasFactory;
    
    // Add start_date and end_date to the fillable array
    protected $fillable = ['name', 'academic_session_id', 'start_date', 'end_date'];

    // Cast the date columns to Carbon instances for easy formatting
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class, 'academic_session_id');
    }
}