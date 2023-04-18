<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Product;
use Illuminate\Validation\Rule;

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

        return [
            'product_name' => [
                'required',
                'min:4',
                Rule::unique('products')->ignore($product->id ?? null)->whereNull('deleted_at')
            ],
            'brand_id' => 'nullable',
            'price' => 'required|numeric',
            'price_discount' => 'nullable|numeric|lt:price',
            'image' => 'required_if:old_image,null|image',
            'productImageThumbnails.*' => 'sometimes|image',
            'short_description' => 'required',
            'category_id' => 'nullable|numeric',
            'long_description' => 'sometimes',
            'color_id' => 'sometimes',
            'old_image' => 'sometimes',
            'old_images' => 'sometimes',
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