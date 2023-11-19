<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RefillLockerRequest extends FormRequest
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
        return [
            'machine_id' => 'required',
            'machine_type' => 'required',
            'machine_model' => 'required',
            'locker_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'buy_unit_price' => 'required',
            'sale_unit_price' => 'required'
        ];
    }
}
