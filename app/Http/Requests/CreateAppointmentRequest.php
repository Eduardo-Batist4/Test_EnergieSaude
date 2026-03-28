<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppointmentRequest extends FormRequest
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
            'patient'    => 'required|integer|exists:patients,id',
            'date'       => 'required|date_format:d/m/Y',
            'time' => 'required|date_format:H:i',
        ];
    }

    public function messages()
    {
        return [
            'patient.required'    => 'O paciente é obrigatório.',
            'patient.exists'      => 'Paciente não encontrado.',
            'date.required'       => 'A data é obrigatória.',
            'date.date_format'    => 'A data deve estar no formato dd/mm/aaaa.',
            'time.required' => 'O horário é obrigatório.',
            'time.date_format' => 'O horário deve estar no formato HH:MM.',
        ];
    }
}
