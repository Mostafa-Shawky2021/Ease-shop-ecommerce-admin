<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreFooterRequest extends FormRequest
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
            'aboutus' => 'required|min:5',
            'address' => '',
            'whatsapp_number' => '',
            'phone' => '',
            'facebook_link' => '',
            'gmail_link' => '',
            'twitter_link' => ''
        ];
    }
}