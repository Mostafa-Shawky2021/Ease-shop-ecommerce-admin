<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryForm extends FormRequest
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

        $category = $this->route('category') ? $this->route('category') : null;

        return [
            'cat_name' => [
                'required',
                Rule::unique('categories')->ignore($category->id ?? null)
            ],
            'parent_id' => 'nullable|integer',
            'image' => 'image',
            'image_thumbnail' => 'image',
        ];
    }
    public function messages()
    {
        return [
            'cat_name.required' => 'من فضلك ادخل اسم للقسم',
            'cat_name.unique' => 'ذلك الاسم موجود مسبقاً',
            'image.image' => 'الصورة يجب ان تكون بصيغة jpg,jpeg,png,bmp,gif,svg,webp',
            'image_thumbnail.image' => 'الصورة يجب ان تكون بصيغة jpg,jpeg,png,bmp,gif,svg,webp',
        ];
    }
}