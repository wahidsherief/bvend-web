<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorRequest extends FormRequest
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
            // 'name' => 'min:5',
            // 'email' => 'unique:vendors|email',
            // 'password' => 'min:6',
            // // 'contact' => 'nullable|digits:11|numeric|unique:vendors',
            // 'contact' => 'nullable|numeric|unique:vendors',
            // 'image' => 'nullable',
            // 'business_name' => 'nullable',
            // // 'additional_contact' => 'nullable|digits:11|numeric|unique:vendors',
            // 'trade_licence_no' => 'nullable|unique:vendors',
            // 'bank_account_no' => 'nullable|unique:vendors',
            // 'nid' => 'nullable|unique:vendors',
            // 'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'The name must be at least 5 characters.',
            'email.unique' => 'The email has already been taken.',
            'email.email' => 'The email must be a valid email address.',
            'password.min' => 'The password must be at least 6 characters.',
            'contact.digits' => 'The contact number must be 11 digits.',
            'contact.numeric' => 'The contact number must be numeric.',
            'contact.unique' => 'The contact number has already been taken.',
            'is_active.boolean' => 'The is_active field must be true or false.',
        ];

    }
}
