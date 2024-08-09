<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequestUpdateStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'status' => 'required|in:in_progress,completed',
            'updated_at' => [
                'required',
                'date',
                'after_or_equal:now',
            ],
        ];
    }
}
