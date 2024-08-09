<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequestRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'aircraft_id' => 'required|exists:aircrafts,id',
            'maintenance_company_id' => 'nullable|exists:maintenance_companies,id',
            'issue_description' => 'required|string',
            'priority' => 'required|in:Low,Medium,High',
            'due_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'status' => 'in:pending,in_progress,completed',
        ];
    }
}
