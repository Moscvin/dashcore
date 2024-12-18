<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialization_id',
    ];
    protected $table = 'doctors';

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specialization_id', 'id');
    }

    public function reservationSlots()
    {
        return $this->hasMany(ReservationSlot::class, 'doctor_id');
    }
    public function hasSpecialization($specializationId)
    {
        return $this->specializations()->where('id', $specializationId)->exists();
    }
}
