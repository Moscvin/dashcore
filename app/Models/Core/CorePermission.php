<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorePermission extends Model
{
    use HasFactory;

    protected $table = 'core_permissions';

    protected $fillable = [
        'core_menu_id',
        'core_group_id',
        'permission'
    ];
}
