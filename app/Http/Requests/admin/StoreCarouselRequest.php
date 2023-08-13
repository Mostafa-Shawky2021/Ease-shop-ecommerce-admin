<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarouselRequest extends FormRequest
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
            'images.*' => 'sometimes|bail|mimes:jpg,jpeg,png|max:2048',
            'carousel_time' => 'required|integer',
            'content' => ''
        ];
    }
    public function messages()
    {
        return [
            'images.*.mimes' => 'الصورة يجب ان تكون بصيغة jpg,jpeg,png',
            'images.*.max' => 'اقصي حجم للصورة 2ميجا',
            'carousel_time.required' => 'من فضلك ادخل قيمة مدة السليدر',
            'carousel_time.integer' => 'مدة السليدر يجب ان تكون رقمية',

        ];
    }
}
