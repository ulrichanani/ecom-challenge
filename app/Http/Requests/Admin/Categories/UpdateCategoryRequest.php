<?php

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
        dump($this->segment(5));
        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('category', 'name')
                ->ignore($this->segment(5), 'category_id')],
            'description' => ['nullable', 'string', 'max:1000']
        ];
    }
}
