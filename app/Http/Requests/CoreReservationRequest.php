<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoreReservationRequest extends FormRequest
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
        // dd($this);
        return [
            'specialization_id' => 'required|exists:specializations,id',
            'slot_times' => 'required|array|min:1', 
            'slot_times.*' => 'required|date|after:now',
        ];
    }
    public function messages()
    {
        return[
            'specialization_id.required' => 'Il campo specialization_id è obbligatorio',
            'specialization_id.exists' => 'Il campo specialization_id deve esistere nella tabella specializations',
            'slot_times.required' => 'Il campo slot_times è obbligatorio',
            'slot_times.array' => 'Il campo slot_times deve essere un array',
            'slot_times.min' => 'Il campo slot_times deve avere almeno un elemento',
            'slot_times.*.required' => 'Il campo slot_times deve avere almeno un elemento',
            'slot_times.*.date' => 'Il campo slot_times deve essere una data valida',
            'slot_times.*.after' => 'Il campo slot_times deve essere una data futura',
        ];
    }
}
