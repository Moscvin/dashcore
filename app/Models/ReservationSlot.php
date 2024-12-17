<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationSlot extends Model
{
    use HasFactory;

    protected $table = 'reservation_slots';
    protected $fillable = ['time', 'doctor_id', 'is_booked'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
