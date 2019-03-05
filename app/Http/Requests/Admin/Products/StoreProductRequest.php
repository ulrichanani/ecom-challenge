<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'discounted_price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['required', 'file'],
            'image_2' => ['nullable', 'file'],
            'thumbnail' => ['required', 'file'],
            'display' => ['integer'],
            'categories' => ['required', 'array'],
            'categories.*' => ['integer'],
            'attributes' => ['nullable', 'array'],
            'attributes.*' => ['integer'],
        ];
    }
}
