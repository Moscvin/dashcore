<?php

namespace App\Models\Core\Addresses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreProvince extends Model
{
    use HasFactory;

    protected $table = 'core_provinces';

    protected $fillable = [
        'name',
        'short_name'
    ];

    public function coreCities()
    {
        return $this->hasMany(CoreCity::class, 'core_province_id');
    }
}
