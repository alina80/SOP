@extends('layouts.admin')
@section('content')
    <h3 class="page-title">{{ trans('global.systemCalendar') }}</h3>
    <div class="card">
        <div class="card-header">
            {{ trans('global.systemCalendar') }}
        </div>

        <div class="card-body">
            <link rel='stylesheet'
                  href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css'/>

            <div id='calendar'></div>


        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script src='fullcalendar/locale/ro.js'></script>
    <script>
        $(document).ready(function () {
            // page is now ready, initialize the calendar...
            events ={!! json_encode($events) !!};
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                header: {
                    left:   'title',
                    center: '',
                    right:  'today agendaDay,agendaWeek,month,year prev,next'
                },
                events: events,
                defaultView: 'agendaWeek',
                businessHours: {
                    // days of week. an array of zero-based day of week integers (0=Sunday)
                    dow: [ 1, 2, 3, 4, 5, 6 ], // Monday - Thursday

                    start: '09:00', // a start time (10am in this example)
                    end: '20:00', // an end time (6pm in this example)
                },
                eventColor: events['color'],
                slotDuration: '00:15:00',
                end: console.log(events['duration']),
            })
        })
    </script>
@stop
