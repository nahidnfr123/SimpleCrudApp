<?php

namespace App\Http\Requests\Product;

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
            'name' => ['required', 'min:3', 'max:255'],
            'status' => ['required'],
            'total_stock' => ['required', 'numeric', 'min:0', 'max:500'],
            'price' => ['required', 'numeric', 'min:0', 'digits_between:1,7'],
            'description' => ['sometimes', 'max:255'],
            'category' => ['required', 'array', 'min:1'],
            'category.*' => "required|string", /// category for displaying error in vue js ...
        ];
    }
}
