@extends('layouts.app')
@section('content')

    <style>
        .fc-header-toolbar {
            /*
        the calendar will be butting up against the edges,
        but let's scoot in the header's buttons
        */
            padding-top: 1em;
            padding-left: 1em;
            padding-right: 1em;
        }

    </style>
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="/">Dashboard</a>
            <a class="breadcrumb-item" href="#">Surat Perintah</a>
            <span class="breadcrumb-item active">Kalender</span>
        </nav>
    </div>

    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Surat Perintah</h4>
    </div>

    <div class="br-pagebody">
        @if (Session::has('message'))
            <div class="row">
                <div class="alert alert-success col-lg-12">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="d-flex align-items-center justify-content-start">
                        <span>{!! Session::get('message') !!}</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12 widget-2 px-0">
                <div class="card shadow-base">
                    <div class="card-header">
                        <h6 class="card-title float-left">List Surat Perintah</h6>
                        <div class="float-right">

                            @if (can_access('pkpt_surat_perintah', 'add'))
                                <a class='btn btn-sm btn-success' href='/pkpt/surat_perintah/add/1'><i
                                        class='menu-item-icon icon ion-plus'></i> Tambah</a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body" style="position: relative;">

                        @foreach ($listcolor as $idx => $row)
                            <div>
                                <div
                                    style="width:10px;height: 10px; background: {{ $row['bgColor'] }}; border: 1px solid {{ $row['borderColor'] }}; color: {{ $row['textColor'] }}; display: inline-block;">
                                </div> {{ $row['label'] }}
                            </div>
                        @endforeach

                        <div id='calendar-container'>
                            <div id='calendar'></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link href='{{ asset('admin_template/lib/full-calendar/packages/core/main.css') }}' rel='stylesheet' />
    <link href='{{ asset('admin_template/lib/full-calendar/packages/daygrid/main.css') }}' rel='stylesheet' />
    <link href='{{ asset('admin_template/lib/full-calendar/packages/timegrid/main.css') }}' rel='stylesheet' />
    <link href='{{ asset('admin_template/lib/full-calendar/packages/list/main.css') }}' rel='stylesheet' />
    <script src='{{ asset('admin_template/lib/full-calendar/packages/core/main.js') }}'></script>
    <script src='{{ asset('admin_template/lib/full-calendar/packages/interaction/main.js') }}'></script>
    <script src='{{ asset('admin_template/lib/full-calendar/packages/daygrid/main.js') }}'></script>
    <script src='{{ asset('admin_template/lib/full-calendar/packages/timegrid/main.js') }}'></script>
    <script src='{{ asset('admin_template/lib/full-calendar/packages/list/main.js') }}'></script>
    <!-- Datatables -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
                height: 'parent',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                defaultView: 'dayGridMonth',
                defaultDate: '{{ date('Y-m-d') }}',
                navLinks: true, // can click day/week names to navigate views
                editable: false,
                displayEventTime: false,
                eventLimit: true, // allow "more" link when too many events
                events: {
                    url: '{{ URL::to('/pkpt/surat_perintah/get_event_sp') }}',
                    method: 'POST',
                    failure: function() {
                        alert('there was an error while fetching events!');
                    },
                    color: 'yellow', // a non-ajax option
                    textColor: 'black' // a non-ajax option
                }
            });

            calendar.render();
        });
        $(function() {

        });

    </script>
@endsection
