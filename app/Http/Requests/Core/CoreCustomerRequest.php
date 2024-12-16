<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class CoreCustomerRequest extends FormRequest
{
    // public function __construct(ValidationFactory $validationFactory)
    // {
    //
    //     $validationFactory->extend(
    //         'is_legal_entity',
    //         function ($attribute, $value, $parameters) {
    //             return (int) $this->is_company == 1;
    //         },
    //         'Sorry, it failed foo validation!'
    //     );
    //
    // }
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
            'company_name' => 'required_if:is_company,1',
            'country_fiscal' => 'required_if:is_company,1',
            'vat' => 'required_if:is_company,1',
            'code_fiscal' => 'required_if:is_company,1',

            'surname' => 'required_if:is_company,0',
            'name' => 'required_if:is_company,0',
            'code_fiscal_individual' => 'required_if:is_company,0',
            'date_birth' => 'nullable|date_format:d/m/Y',

            'prefix_1' => 'required_with:phone_1',
            'prefix_2' => 'required_with:phone_2',
            'prefix_fax' => 'required_with:fax',
            'phone_1' => 'nullable|numeric|digits_between:0,12',
            'phone_2' => 'nullable|numeric|digits_between:0,12',
            'fax' => 'nullable|numeric|digits_between:0,12',
            'email' => 'nullable|email',
            'pec' => 'nullable|email',

            'rl_prefix_1' => 'required_with:rl_phone_1',
            'rl_prefix_2' => 'required_with:rl_phone_2',
            'rl_phone_1' => 'nullable|numeric|digits_between:0,12',
            'rl_phone_2' => 'nullable|numeric|digits_between:0,12',
            'rl_email' => 'nullable|email',

            'referent_prefix_1' => 'required_with:referent_phone_1',
            'referent_prefix_2' => 'required_with:referent_phone_2',
            'referent_phone_1' => 'nullable|numeric|digits_between:0,12',
            'referent_phone_2' => 'nullable|numeric|digits_between:0,12',
            'referent_email' => 'nullable|email',
        ];
    }

    public function messages(){
        return [
            'company_name.required_if' => 'Il campo :attribute è richiesto quando Tipo cliente è Persona giuridica.',
            'country_fiscal.required_if' => 'Il campo :attribute è richiesto quando Tipo cliente è Persona giuridica.',
            'vat.required_if' => 'Il campo :attribute è richiesto quando Tipo cliente è Persona giuridica.',
            'code_fiscal.required_if' => 'Il campo :attribute è richiesto quando Tipo cliente è Persona giuridica.',
            'surname.required_if' => 'Il campo :attribute è richiesto quando Tipo cliente è Persona fisica.',
            'name.required_if' => 'Il campo :attribute è richiesto quando Tipo cliente è Persona fisica.',
            'code_fiscal_individual.required_if' => 'Il campo :attribute è richiesto quando Tipo cliente è Persona fisica.',
        ];
    }
    public function attributes(){
        return [
            'company_name' => 'Ragione Sociale',
            'is_company' => 'Tipo cliente',
            'country_fiscal' => 'Nazione fiscale',
            'vat' => 'Partita IVA',
            'code_fiscal' => 'Codice Fiscale',
            'surname' => 'Cognome',
            'name' => 'Nome',
            'code_fiscal_individual' => 'Codice Fiscale',
            'date_birth' => 'Data di nascita',
            'prefix_1' => 'Prefisso telefonico 1',
            'prefix_2' => 'Prefisso telefonico 2',
            'prefix_fax' => 'Prefisso fax',
            'phone_1' => 'Telefono 1',
            'phone_2' => 'Telefono 2',
            'fax' => 'Fax',
            'email' => 'Email',
            'pec' => 'PEC',
            'rl_prefix_1' => 'Rappresentante Legale prefisso 1',
            'rl_prefix_2' => 'Rappresentante Legale prefisso 2',
            'rl_phone_1' => 'Rappresentante Legale telefono 1',
            'rl_phone_2' => 'Rappresentante Legale telefono 2',
            'rl_email' => 'Rappresentante Legale email',
            'referent_prefix_1' => 'Referente prefisso 1',
            'referent_prefix_2' => 'Referente prefisso 2',
            'referent_phone_1' => 'Referente telefono 1',
            'referent_phone_2' => 'Referente telefono 2',
            'referent_email' => 'Referente email',
        ];
    }
}
