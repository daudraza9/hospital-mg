<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable=[
      'floor_no',
        'room_no',
        'total_bed'
    ];
    public function roomPatient()
    {
        return $this->hasMany(RoomPatient::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'room_patient', 'room_id', 'patient_id');
    }
}
