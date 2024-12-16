<?php

namespace App\Http\Requests\Core\Addresses;

use Illuminate\Foundation\Http\FormRequest;

class CoreCityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'core_province_id' => 'required|exists:core_provinces,id',
            'name' => 'required|string',
            'zip' => 'required|numeric|max:99999',
        ];
    }
}
