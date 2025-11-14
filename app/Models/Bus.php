<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;
    protected $fillable = ['bus_name', 'plate_number', 'driver_name', 'driver_phone', 'transport_route_id'];

    public function route() { return $this->belongsTo(TransportRoute::class, 'transport_route_id'); }
    public function students() { return $this->belongsToMany(Student::class, 'student_transport'); }
}