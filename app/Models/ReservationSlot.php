<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationSlot extends Model
{
    use HasFactory;

    protected $table = 'reservation_slots';
    protected $fillable = ['time'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
