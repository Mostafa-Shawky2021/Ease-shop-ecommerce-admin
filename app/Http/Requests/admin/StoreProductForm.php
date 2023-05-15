<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class StoreProductForm extends FormRequest
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
            'short_description' => '',
            'category_id' => 'nullable|numeric',
            'long_description' => 'sometimes',
            'color_id' => 'sometimes',
            'productImageThumbnails.*' => 'sometimes|image',
            'size_id' => 'sometimes'
        ];
    }
    public function messages()
    {
        return [
            'product_name.required' => 'من فضلك ادخل اسم للمنتج',
            'product_name.min' => 'يجب ان يكون الاسم بحد ادني 4 حروف',
            'product_name.unique' => 'اسم المنتج موجود بالفعل',
            'price.required' => 'من فضلك ادخل سعر المنتج',
            'price.numeric' => 'يجب ان يكون السعر قيمة رقمية',
            'price_discount.numeric' => 'يجب ان يكون السعر بعد الخصم قيمة رقمية',
            'price_discount.lt' => 'يجب ان يكون السعر بعد الخصم اقل من السعر الاصلي',
            'image.required_if' => 'يجب اختيار صورة علي الاقل للمنتج',
            'image.image' => 'الصورة يجب ان تكون بصيغة jpg,jpeg,png,bmp,gif,svg,webp',
            'productImageThumbnails.*.image' => 'الصورة يجب ان تكون بصيغة jpg,jpeg,png,bmp,gif,svg,webp',
        ];
    }
}