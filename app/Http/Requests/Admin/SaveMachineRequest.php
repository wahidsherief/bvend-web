<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveMachineRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust as needed based on your authentication logic
    }

    public function rules()
    {
        return [
            'machine_type_id' => 'required|integer',
            'no_of_rows' => 'required|integer',
            'no_of_columns' => 'required|integer',
            'capacity' => 'required|integer',
            'qr_code' => 'string',
            'bkash_qr_code' => 'image',
            'vendor_id' => 'required|integer',
            'location' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'integer' => 'The :attribute field must be an integer.',
            'date' => 'The :attribute field must be a valid date.',
        ];
    }

    public function attributes()
    {
        return [
            'machine_code' => 'Machine Code',
            'machine_types_id' => 'Machine Type ID',
            'no_of_rows' => 'Number of Rows',
            'no_of_columns' => 'Number of Channels',
            'capacity' => 'Number of channel capacity',
            'qr_code' => 'QR Code',
            'bkash_qr_code' => 'bKash QR Code',
            'vendor_id' => 'Vendors ID',
            'location' => 'Location',
        ];
    }
}
