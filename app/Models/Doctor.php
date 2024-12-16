<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    protected $table = 'doctors';

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'doctor_specialization', 'doctor_id', 'specialization_id');
    }
}
