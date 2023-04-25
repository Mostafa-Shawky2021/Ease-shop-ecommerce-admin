<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
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
            'user_id' => 'required',
            'product_id' => 'required',
            'size' => 'nullable',
            'color' => 'nullable',
            'quantity' => 'required|integer',
            'unit_price' => 'required|numeric',
            'total_price' => 'required|numeric',
        ];
    }
}