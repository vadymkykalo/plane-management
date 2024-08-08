<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AircraftRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $aircraftId = $this->route('aircraft') ? $this->route('aircraft') : 'NULL';

        return [
            'model' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:aircrafts,serial_number,' . $aircraftId,
            'registration' => 'required|string|max:255|unique:aircrafts,registration,' . $aircraftId,
        ];
    }
}
