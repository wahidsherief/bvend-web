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
            'machine_types_id' => 'required|integer',
            'no_of_rows' => 'required|integer',
            'no_of_columns' => 'required|integer',
            'locks_per_column' => 'required|integer',
            'qr_code' => 'required|string',
            'vendors_id' => 'required|integer',
            'assign_date' => 'nullable|date',
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
            'no_of_trays' => 'Number of Trays',
            'locks_per_tray' => 'Locks per Tray',
            'qr_code' => 'QR Code',
            'vendors_id' => 'Vendors ID',
            'assign_date' => 'Assign Date',
            'location' => 'Location',
        ];
    }
}
