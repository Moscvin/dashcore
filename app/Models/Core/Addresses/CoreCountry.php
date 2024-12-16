<?php

namespace App\Models\Core\Addresses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreCountry extends Model
{
    use HasFactory;

    protected $table = 'core_countries';

    protected $fillable = [
        'name',
        'short_name'
    ];
}
