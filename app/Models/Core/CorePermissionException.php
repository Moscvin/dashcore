<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorePermissionException extends Model
{
    use HasFactory;

    protected $table = 'core_permission_exceptions';

    protected $fillable = [
        'core_menu_id',
        'core_user_id',
        'permission'
    ];

    public function coreUser()
    {
        return $this->belongsTo(CoreUser::class, "core_user_id");
    }

    public function coreMenu()
    {
        return $this->belongsTo(CoreMenu::class, "core_menu_id");
    }
}
