<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

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
        $catNameRules = ['required', 'min:3'];

        $category = $this->route('category') ? $this->route('category') : null;

        if ($category && $this->input('cat_name') !== $category->cat_name) {
            $catNameRules[] = "unique:categories";

        }
        return [
            'cat_name' => $catNameRules,
            'image' => 'required_if:old_image,null|image',
            'parent_id' => '',
            'old_image' => '',
        ];
    }
}