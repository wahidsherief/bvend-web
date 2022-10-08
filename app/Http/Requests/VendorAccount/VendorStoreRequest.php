<?php

namespace App\Http\Requests\VendorAccount;

use Illuminate\Foundation\Http\FormRequest;

class VendorStoreRequest extends FormRequest
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
            'name' => 'required|min:5',
            'email' => 'required|unique:vendors|email',
            'phone' => 'required|digits:11|numeric|unique:vendors',
            'business_phone' => 'required|digits:11|numeric|unique:vendors',
            'password' => 'required|min:6',
            'business_name' => 'required|unique:vendors',
            'trade_licence_no' => 'required|regex:/^[0-9]+$/|max:20|unique:vendors',
            'bank_account_no' => 'required|regex:/^[0-9]+$/|max:20|unique:vendors',
            'nid' => 'required|digits_between:10,13|unique:vendors',
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'Name should be at least 5 characters',
            'phone.digits' => 'Phone number is not valid',
            'phone.unique' => 'Phone number has already been taken',
            'business_phone.digits' => 'Business phone number is not valid',
            'business_phone.unique' => 'Business phone number has already been taken',
            'password.min' => 'Password should be at least 6 characters',
            'business_name.unique' => 'Business name has already been taken',
            'trade_licence_no.regex' => 'Trade licence number is not valid',
            'trade_licence_no.unique' => 'Trade licence number is duplicate',
            'bank_account_no.regex' => 'Bank account number is not valid',
            'bank_account_no.unique' => 'Bank account number is duplicate',
            'nid.digits_between' => 'NID number is not valid',
            'nid.unique' => 'NID number is duplicate',
            'nid.digits_between' => 'NID number is not valid',
        ];
    }
}
