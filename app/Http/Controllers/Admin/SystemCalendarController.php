<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemCalendarController extends Controller
{
    public function index()
    {
        $events = [];

//        $appointments = Appointment::with(['client', 'employee'])->get();
//
//        foreach ($appointments as $appointment) {
//            if (!$appointment->start_time) {
//                continue;
//            }
//
//            $events[] = [
//                'title' => $appointment->client->name . ' ('.$appointment->employee->name.')',
//                'start' => $appointment->start_time,
//                'url'   => route('admin.appointments.edit', $appointment->id),
//            ];
//        }

        return view('admin.calendar.calendar', compact('events'));
    }
}
