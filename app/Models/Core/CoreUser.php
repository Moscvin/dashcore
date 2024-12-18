<?php

namespace App\Models\Core;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class CoreUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'core_users';

    protected $fillable = [
        'core_group_id',
        'name',
        'email',
        'surname',
        'username',
        'active',
        'first_login',
        'password'
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'app_token'
    ];

    public function coreGroup()
    {
        return $this->belongsTo(CoreGroup::class, 'core_group_id');
    }

    public function getFullNameAttribute()
    {
        return $this->surname . ' ' . $this->name;
    }
    public function getActiveTextAttribute()
    {
        return $this->active ? 'Si' : 'No';
    }

    public function permissionExceptions()
    {
        return $this->hasMany(CorePermissionException::class, 'core_user_id')->whereNotNull('permission')->where('permission', '!=', '');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'core_user_id', 'id');
    }
}
