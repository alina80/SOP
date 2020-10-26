<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemCalendarController extends Controller
{
    public function index()
    {
        $events = [];

        $appointments = Appointment::with(['status', 'employee'])->get();

        foreach ($appointments as $appointment) {
            if (!$appointment->start_time) {
                continue;
            }

            $events[] = [
                'title' => $appointment->client . ' ('.$appointment->employee->user->name.')',
                'start' => $appointment->start_time,
                'finish' => $appointment->finish_time,
                'url'   => route('admin.appointments.edit', $appointment->id),
            ];
        }

        return view('admin.calendar.calendar', compact('events'));
    }
}
