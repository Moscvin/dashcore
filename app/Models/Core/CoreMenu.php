<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreMenu extends Model
{
    use HasFactory;

    protected $table = 'core_menus';

    protected $fillable = [
        'description',
        'parent_id',
        'list_order',
        'icon',
        'link',
        'show'
    ];

    public static function tree()
    {
        return static::with('children.children.children')->where('parent_id', '0')->orderBy('list_order')->get();
    }

    public function children()
    {
        return $this->hasMany(CoreMenu::class, 'parent_id')->orderBy('list_order', 'asc');
    }

    public function parentMenu()
    {
        return $this->belongsTo(CoreMenu::class, 'parent_id');
    }

    public function corePermissions()
    {
        return $this->hasMany(CorePermission::class, 'core_menu_id');
    }

    public function corePermissionsExceptions()
    {
        return $this->hasMany(CorePermissionException::class, 'core_menu_id');
    }

    public function delete()
    {
        $this->corePermissions->each(function($corePermission) {
            $corePermission->delete();
        });

        $this->corePermissionsExceptions->each(function($corePermissionException) {
            $corePermissionException->delete();
        });

        $this->corePermissionsExceptions->each(function($corePermissionException) {
            $corePermissionException->delete();
        });

        return parent::delete();
    }
}
