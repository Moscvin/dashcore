<?php

namespace App\Http\Requests\Core;

use App\Models\Core\CoreUser;
use Illuminate\Foundation\Http\FormRequest;

class CoreUserRequest extends FormRequest
{
    protected $rules = [
        'username' => 'required|unique:core_users,username|min:3',
        'email' => 'required|unique:core_users,email|min:3',
        'surname' => 'required|min:3',
        'core_group_id' => 'required|not_in:0',
        'active' => 'required|numeric|max:1'
    ];

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
        if ($this->getMethod() == "PATCH") {
            $this->rules['email'] = 'required|email|unique:core_users,email,'. request()->route('coreUser')->id .',id';
            $this->rules['username'] = 'required|unique:core_users,username,'. request()->route('coreUser')->id .',id';
        }

        return $this->rules;
    }
}
