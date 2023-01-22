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
            'productName' => 'required',
            'brandName' => 'required',
            'price' => 'required|numeric',
            'priceDiscount' => 'nullable|numeric|lt:price',
            'productImage' => 'sometimes|image',
            'productImageThumbnails.*' => 'sometimes|image',
            'shortDescription' => 'required',
            'categoryId' => 'required|numeric'
        ];
    }
    public function messages()
    {
        return [
            'productImageThumbnails.*.image' => 'Thumbnails must be image type only',
        ];
    }
}