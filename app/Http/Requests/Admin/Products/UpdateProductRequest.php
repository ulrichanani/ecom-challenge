<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'discounted_price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'file'],
            'image_2' => ['nullable', 'file'],
            'thumbnail' => ['nullable', 'file'],
            'display' => ['nullable', 'integer']
        ];
    }
}
