<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'house_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'nullable',
            'gender' => 'nullable',
            'dob' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable',
            'polling_station_id' => 'nullable',
            'employment_id' => 'nullable',
            'is_volunteer' => 'required',
            'is_witness' => 'required',
            'is_deceased' => 'required'
        ];
    }
}
