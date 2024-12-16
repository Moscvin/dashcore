<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreGroup extends Model
{
    use HasFactory;

    protected $table = 'core_groups';

    protected $fillable = [
        'name'
    ];
}
