<?php

namespace App\Rules;

use App\Appointment;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

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
       return Appointment::where('employee_id','==',$value)->where(function ($query) use ($value) {
           $query->where('start_time','<',$value)->where('finish_time','>',$value);
           })->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Appointment time overlaps with existing appointment(s) !';
    }
}
