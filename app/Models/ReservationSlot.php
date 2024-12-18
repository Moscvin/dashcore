<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationSlot extends Model
{
    use HasFactory;

    protected $table = 'reservation_slots';
    protected $fillable = ['time', 'doctor_id', 'is_booked','reservation_id'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
    public function isBooked()
    {
        return $this->is_booked;
    }
    public static function availableSlotsForDoctor($doctorId)
    {
        return self::where('doctor_id', $doctorId)->where('is_booked', false)->get();
    }
}
