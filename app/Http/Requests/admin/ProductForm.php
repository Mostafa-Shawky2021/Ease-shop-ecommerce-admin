<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Product;

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
        $product = $this->route('product');
        $productNameRule = ['min:5', 'required'];

        if ($product) {
            if ($this->input('product_name') !== $product->product_name) {
                $productNameRule[] = 'unique:products';
            }

        }
        return [
            'product_name' => $productNameRule,
            'brand' => '',
            'price' => 'required|numeric',
            'price_discount' => 'nullable|numeric|lt:price',
            'image' => 'required_if:old_image,null|image',
            'productImageThumbnails.*' => 'sometimes|image',
            'short_description' => 'required',
            'category_id' => 'required|numeric',
            'long_description' => 'sometimes',
            'color_id' => 'sometimes',
            'old_image' => 'sometimes',
            'size_id' => 'sometimes'
        ];
    }
    public function messages()
    {
        return [
            'productImageThumbnails.*.image' => 'Thumbnails must be image type only',
        ];
    }
}