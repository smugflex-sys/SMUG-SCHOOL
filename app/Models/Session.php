<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * This is the crucial line that solves the database conflict.
     *
     * @var string
     */
    protected $table = 'academic_sessions';

    protected $fillable = ['name', 'is_active'];

    public function terms(): HasMany
    {
        return $this->hasMany(Term::class, 'academic_session_id');
    }
}