<?php

namespace App\Models\Core\Addresses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreCity extends Model
{
    use HasFactory;

    protected $table = 'core_cities';

    protected $fillable = [
        'core_province_id',
        'name',
        'zip'
    ];

    public function coreProvince()
    {
        return $this->belongsTo(CoreProvince::class, 'core_province_id');
    }
}
