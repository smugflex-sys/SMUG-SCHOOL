<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradingSystem extends Model
{
    use HasFactory;
    protected $fillable = ['grade_name', 'mark_from', 'mark_to', 'remark'];
}