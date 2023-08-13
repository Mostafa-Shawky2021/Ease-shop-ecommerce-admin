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
            'image' => 'sometimes|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'image_thumbnail' => 'sometimes|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'cat_name.required' => 'من فضلك ادخل اسم للقسم',
            'cat_name.unique' => 'الاسم موجود مسبقاً',
            'image.mimes' => 'الصورة يجب ان تكون بصيغة jpg,jpeg,png,gif,webp',
            'image.max' => 'اقصي حجم للصورة هو 2ميجا',
            'image_thumbnail.mimes' => 'الصورة يجب ان تكون بصيغة jpg,jpeg,png,gif,webp',
            'image_thumbnail.max' => 'اقصي حجم للصورة هو 2ميجا',
        ];
    }
}
