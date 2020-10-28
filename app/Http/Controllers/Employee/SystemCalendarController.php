<?php

namespace App\Http\Controllers\Employee;

use App\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemCalendarController extends Controller
{
    public function index()
    {
        $events = [];

        $employeeId = auth()->user()->getEmployeeId();

        $appointments = Appointment::with(['status', 'employee', 'services'])->get();

        foreach ($appointments as $appointment) {
            if (!$appointment->start_time) {
                continue;
            }

            if ($appointment->employee_id == $employeeId){

                $events[] = [
                    'title' => $appointment->client,
                    'start' => $appointment->start_time,
                    'finish' => $appointment->finish_time,
                    'url'   => route('employee.appointments.edit', $appointment->id),
                ];
            }

        }

        return view('employee.calendar.calendar', compact('events'));
    }
}
