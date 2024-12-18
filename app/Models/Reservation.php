<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    public const STATUS_LOCKED = '1';
    public const STATUS_UNLOCKED = '0';

    protected $fillable = [
        'core_user_id',
        'doctor_id',
        'specialization_id',
        'reservation_slot_id',
        'status',
    ];

    protected $with = ['doctor', 'specialization', 'reservationSlot'];

    protected $table = 'reservations';

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }
    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specialization_id', 'id');
    }
    public function reservationSlot()
    {
        return $this->belongsTo(ReservationSlot::class, 'reservation_slot_id', 'id');
    }
    public function coreUser()
    {
        return $this->belongsTo(\App\Models\Core\CoreUser::class, 'core_user_id', 'id');
    }
    public function isEditable()
    {
        return $this->status == self::STATUS_UNLOCKED;
    }
    public function isConfirmed()
    {
        return $this->status == self::STATUS_LOCKED;
    }
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
