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
    <script src="{{ asset('assets/fullcalendar/locale/ro.js') }}"></script>
    <script>
        $(document).ready(function () {
            // page is now ready, initialize the calendar...
            let events ={!! json_encode($events) !!};
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                header: {
                    left:   'title',
                    center: '',
                    right:  'today agendaDay,agendaWeek,month,year prev,next'
                },
                locale: '{{ app()->getLocale() }}',
                events: events,
                forceEventDuration: true,
                navLinks: true,
                businessHours: {
                    dow: [ 0, 1, 2, 3, 4, 5, 6 ],
                    start: '09:00',
                    end: '20:00',
                },
                eventColor: events['color'],
                slotDuration: '00:15:00',
                selectable: true,
                eventLimit: true,

            });

        });
    </script>
@stop
