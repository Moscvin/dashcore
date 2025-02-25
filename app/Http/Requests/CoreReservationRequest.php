<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Reservation;

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
        $rules = [
            'specialization_id' => [
                'exists:specializations,id'
            ],
            'slot_times' => 'required|array|min:1',
            'slot_times.*' => [
                'required',
                'date',
                'after:now',
                function ($attribute, $value, $fail) {
                    $exists = Reservation::where('specialization_id', $this->input('specialization_id'))
                        ->where('core_user_id', $this->user()->id)
                        ->whereHas('reservationSlots', function ($query) use ($value) {
                            $query->where('time', $value);
                        })
                        ->when($this->route('coreReservation'), function ($query) {
                            $query->where('id', '!=', $this->route('coreReservation')->id);
                        })
                        ->exists();

                    if ($exists) {
                        $fail('This slot time is occupied.');
                    }
                }
            ],
        ];

        if ($this->routeIs('manager_reservation.*')) {
            $rules['specialization_id'][] = 'nullable';
            $rules['slot_times'] = 'required|date|after:now';
            unset($rules['slot_times.*']);
        }

        return $rules;
    }

    /**
     * Get custom error messages for validation.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages = [
            'specialization_id.required' => 'Câmpul specializare este obligatoriu.',
            'specialization_id.exists' => 'Specializarea selectată nu există.',
            'slot_times.required' => 'Trebuie să adăugați cel puțin un interval de timp.',
            'slot_times.array' => 'Intervalele de timp trebuie să fie un array.',
            'slot_times.min' => 'Trebuie să adăugați cel puțin un interval de timp.',
            'slot_times.*.required' => 'Fiecare interval de timp este obligatoriu.',
            'slot_times.*.date' => 'Fiecare interval de timp trebuie să fie o dată validă.',
            'slot_times.*.after' => 'Fiecare interval de timp trebuie să fie în viitor.',
        ];

        if ($this->routeIs('manager_reservation.*')) {
            unset($messages['slot_times.array']);
            unset($messages['slot_times.min']);
        }

        return $messages;
    }
}
