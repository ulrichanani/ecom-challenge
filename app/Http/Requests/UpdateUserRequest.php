<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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

    public function attributes()
    {
        return \App\Models\Customer::FIELDS_LABELS;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'credit_card' => ['nullable', 'string'],
            'address_1' => ['nullable', 'string'],
            'address_2' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'region' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string'],
            'country' => ['nullable', 'string'],
            'shipping_region_id' => ['nullable', 'integer'],
            'day_phone' => ['nullable', 'string'],
            'eve_phone' => ['nullable', 'string'],
            'mob_phone' => ['nullable', 'string']
        ];
    }
}
