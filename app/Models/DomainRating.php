<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomainRating extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'term_id', 'domain_id', 'rating'];

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }
}