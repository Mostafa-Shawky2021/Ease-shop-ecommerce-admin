<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductForm extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_name' => 'required|min:5|unique:products',
            'brand' => 'required',
            'price' => 'required|numeric',
            'price_discount' => 'nullable|numeric|lt:price',
            'image' => 'sometimes|image',
            'productImageThumbnails.*' => 'sometimes|image',
            'short_description' => 'required',
            'category_id' => 'required|numeric'
        ];
    }
    public function messages()
    {
        return [
            'productImageThumbnails.*.image' => 'Thumbnails must be image type only',
        ];
    }
}