<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return[

            'discount_amount' => 'nullable|numeric',

            'items' => 'required|array|min:1',

            'items.*.item_name' => 'required|string|max:255',

            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',

            'items.*.gst_rate' => 'required|numeric|min:0|max:100',
        ];
    }
}
