<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreAdminOption extends Model
{
    use HasFactory;

    protected $table = 'core_admin_options';

    protected $fillable = [
        'description',
        'value'
    ];

    public static function getPlucked()
    {
        return self::pluck('value', 'description');
    }

    public static function getOption($description)
    {
        return self::where('description', $description)->first()->value ?? '';
    }
}
