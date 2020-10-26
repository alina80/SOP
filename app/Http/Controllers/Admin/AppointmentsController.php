<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAppointmentRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Service;
use App\Status;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Appointment::with(['employee', 'services','status'])->select(sprintf('%s.*', (new Appointment)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'appointment_show';
                $editGate      = 'appointment_edit';
                $deleteGate    = 'appointment_delete';
                $crudRoutePart = 'appointments';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('client', function ($row) {
                return $row->client ? $row->client : '';
            });

            $table->addColumn('employee_id', function ($row) {
                return $row->employee ? $row->employee->user->name : '';
            });

            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : "";
            });
            $table->editColumn('comments', function ($row) {
                return $row->comments ? $row->comments : "";
            });

            $table->editColumn('services', function ($row) {
                $labels = [];

                foreach ($row->services as $service) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $service->title);
                }

                return implode(', ', $labels);
            });

            $table->addColumn('status', function ($row) {
                return $row->status ? $row->status->title : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'status', 'employee', 'services']);

            return $table->make(true);
        }

        return view('admin.appointments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('appointment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

       // $clients = Client::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = Employee::all()->pluck('user.name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $services = Service::all()->pluck('title', 'id');

        return view('admin.appointments.create', compact('employees', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppointmentRequest $request)
    {
        $appointment = Appointment::create($request->all());
        $appointment->services()->sync($request->input('services', []));

        return redirect()->route('admin.appointments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointment->load('employee', 'services', 'status');

        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuses = Status::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = Employee::all()->pluck('user_id', 'id')->prepend(trans('global.pleaseSelect'), '');

        $services = Service::all()->pluck('title', 'id');

        $appointment->load('employee', 'services', 'status');

        return view('admin.appointments.edit', compact('employees', 'services', 'appointment', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->all());
        $appointment->services()->sync($request->input('services', []));

        return redirect()->route('admin.appointments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointment->delete();

        return back();
    }

    public function massDestroy(MassDestroyAppointmentRequest $request)
    {
        Appointment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
