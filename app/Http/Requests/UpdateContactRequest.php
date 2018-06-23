<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('contacts', 'email')->ignore((int) $this->route()->contact),
                'max:255'
            ],
            'phone' => 'required|integer',
            'city'  => 'required|max:255',
            'state' => 'required|min:2|max:2'
        ];
    }
}
