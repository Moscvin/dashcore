<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoreSlotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'time' => ['required', 'date_format:Y-m-d H:i'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'is_booked' => ['nullable', 'boolean'],
        ];
    }
    public function messages(): array
    {
        return [
            'time.required' => 'Il campo time è obbligatorio',
            'time.date_format' => 'Il campo time deve essere una data valida',
            'doctor_id.required' => 'Il campo doctor_id è obbligatorio',
            'doctor_id.exists' => 'Il campo doctor_id deve esistere nella tabella doctors',
            'is_booked.boolean' => 'Il campo is_booked deve essere un booleano',
        ];
    }
}
