<?php

namespace App\Rules;

use App\Appointment;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\App;

class AppointmentOverlap implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!Appointment::where('employee_id',$value)->count() == 0){

            return Appointment::where('start_time','<=', $value)->where('finish_time','>=', $value)->count() == 0;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Appointment time overlaps with the existing appointment(s)!';
    }
}
