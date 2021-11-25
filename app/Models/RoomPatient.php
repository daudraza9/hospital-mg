<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoomPatient extends Pivot
{
    use HasFactory;
    protected $fillable=[
      'room_id',
      'patient_id'
    ];
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
