<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Add this

class SchoolClass extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    /**
     * The subjects offered in this class.
     */
    public function subjects(): BelongsToMany // Add this method
    {
        return $this->belongsToMany(Subject::class, 'class_subject');
    }
}