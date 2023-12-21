<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveVendorRequest extends FormRequest
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
            'password' => 'required|min:6',
            'contact' => 'nullable|numeric|unique:vendors',
            'image' => 'required',
            'business_name' => 'nullable',
            'additional_contact' => 'nullable|numeric|unique:vendors',
            'trade_licence_no' => 'nullable|unique:vendors',
            // 'bank_account_no' => 'nullable|regex:/^[0-9]+$/|max:20|unique:vendors',
            'bank_account_no' => 'nullable|unique:vendors',
            'nid' => 'nullable|unique:vendors',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.min' => 'The name must be at least 5 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'contact.digits' => 'The contact must be 11 digits.',
            'contact.numeric' => 'The contact must be a number.',
            'contact.unique' => 'The contact has already been taken.',
            'image.required' => 'The image field is required.',
            'additional_contact.digits' => 'The additional contact must be 11 digits.',
            'additional_contact.numeric' => 'The additional contact must be a number.',
            'additional_contact.unique' => 'The additional contact has already been taken.',
            'trade_licence_no.regex' => 'The trade licence number is not valid.',
            'trade_licence_no.max' => 'The trade licence number may not be greater than :max characters.',
            'trade_licence_no.unique' => 'The trade licence number has already been taken.',
            'bank_account_no.regex' => 'The bank account number is not valid.',
            'bank_account_no.max' => 'The bank account number may not be greater than :max characters.',
            'bank_account_no.unique' => 'The bank account number has already been taken',
            'nid.digits_between' => 'The NID number must be between 10 and 13 digits.',
            'nid.unique' => 'The NID number has already been taken.',
            'is_active.boolean' => 'The is active field must be true or false.',
        ];
    }
}
