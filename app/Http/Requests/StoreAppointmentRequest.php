<?php

namespace App\Http\Requests;

use App\Rules\AppointmentOverlap;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Gate;

use App\Appointment;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('appointment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'client'   => [
                'required',
                'string',
            ],
            'employee_id'   => [
                'required',
                'integer',
                new AppointmentOverlap(),
            ],
            'start_time'  => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                new AppointmentOverlap(),
            ],
            'finish_time' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                new AppointmentOverlap(),
            ],
            'services.*'  => [
                'integer',
            ],
            'services'    => [
                'array',
            ],
        ];
    }
}
