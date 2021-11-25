<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'age',
        'weight',
        'address',
        'disease',
        'gender'
    ];

    public function doctorPatient()
    {
        return $this->hasMany(DoctorPatient::class);
    }
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class,'doctor_patient','patient_id','doctor_id');
    }

    public function roomPatient()
    {
        return $this->hasMany(RoomPatient::class);
    }
    public function rooms()
    {
        return $this->belongsToMany(Room::class,'room_patient','patient_id','room_id');
    }

}
