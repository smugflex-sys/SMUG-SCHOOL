<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultPin extends Model
{
    use HasFactory;
    protected $fillable = ['pin', 'usage_limit', 'times_used', 'is_active'];
}