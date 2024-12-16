<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreCustomer extends Model
{
    use HasFactory;

    protected $table = 'core_customers';

    protected $fillable = [
        'is_company',
        'company_name',
        'surname',
        'name',

        'date_birth',
        'city_birth',
        'province_birth',
        'country_birth',
        'country_fiscal',
        'vat',
        'code_fiscal',

        'prefix_1',
        'phone_1',
        'prefix_2',
        'phone_2',
        'prefix_fax',
        'fax',
        'email',
        'pec',

        'country_sl',
        'province_sl',
        'city_sl',
        'zip_sl',
        'street_address_sl',
        'house_number_sl',

        'country_so',
        'province_so',
        'city_so',
        'zip_so',
        'street_address_so',
        'house_number_so',

        'rl_surname',
        'rl_name',
        'rl_phone_1',
        'rl_prefix_1',
        'rl_phone_2',
        'rl_prefix_2',
        'rl_email',

        'referent_description',
        'referent_name',
        'referent_surname',
        'referent_phone_1',
        'referent_prefix_1',
        'referent_phone_2',
        'referent_prefix_2',
        'referent_email',

        'active'
    ];

    public function getCustomerNameAttribute()
    {
        return $this->is_company == 1 ? $this->company_name : "{$this->surname} {$this->name}";
    }

    public function getCustomerPhonesAttribute()
    {
        $phones = !empty($this->phone_1)? $this->prefix_1.' '.$this->phone_1 : '';
        if ($this->phone_1 && $this->phone_2) {
            $phones .= ( ", ");
        }

        $phones .= !empty($this->phone_2)? $this->prefix_2.' '.$this->phone_2 : '';
        return $phones;
    }

    public function getHeadquarterCityAttribute()
    {
        if (strtolower($this->country_sl) == 'italia') {
            $headquarterCity = "{$this->city_sl} {$this->province_sl}";
        } else {
            $headquarterCity = $this->city_sl ? "{$this->country_sl}  –  {$this->city_sl}" : "{$this->country_sl}";
        }
        return $headquarterCity;
    }

    public function getOptionalHeadquarterCityAttribute()
    {
        return strtolower($this->country_so) == 'italia' ? "{$this->city_so} {$this->province_so}" : "{$this->country_so} – {$this->city_so}";
    }

    public function getDateBirthItAttribute()
    {
        return date('d/m/Y', strtotime($this->date_birth));
    }

    public function getTypeTextAttribute()
    {
        return $this->is_company ? 'Persona giuridica' : 'Persone fisica';
    }
}
