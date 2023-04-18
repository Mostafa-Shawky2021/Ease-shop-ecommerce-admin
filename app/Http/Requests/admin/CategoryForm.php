<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryForm extends FormRequest
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
            'image' => 'required_if:old_image,null|image',
            'image_thumbnail' => 'sometimes|image'
        ];
    }
}