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
        $employeeId = $_POST['employee_id'];

//        if ($employeeId != Appointment::where('employee_id','==', $value)){
//            $response = Appointment::where('start_time', '<', $value)->where('finish_time','>', $value)->where('employee_id','<>',$employeeId)->count() == 0;
//        }
        $response = Appointment::where('start_time', '<', $value)->where('finish_time','>', $value)->where('employee_id','<>',$employeeId)->count() == 0;
        return $response;
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
