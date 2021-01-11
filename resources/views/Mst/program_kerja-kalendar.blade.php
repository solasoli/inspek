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

@php
  $list_arr = [];
  $listcolor = [
    1 => [
      'bgColor' => '#3788d8',
      'borderColor' => '#3788d8',
      'textColor' => '#fff',
      'label' => 'PKPT'
    ],
    2 => [
      'bgColor' => '#f8d7da',
      'borderColor' => '#f5c6cb',
      'textColor' => '#721c24',
      'label' => 'NON-PKPT'
    ]
  ];
@endphp

@foreach($program_kerja as $idx => $row)
  @php

  $list_arr[] = [
    "title" => $row->sasaran,
    "start" => $row->dari,
    "end" => date("Y-m-d 23:59:59", strtotime($row->sampai)),
    "url" => "#". $row->id,
    "backgroundColor" => $listcolor[$row->type_pkpt]['bgColor'],
    "borderColor" => $listcolor[$row->type_pkpt]['borderColor'],
    "textColor" => $listcolor[$row->type_pkpt]['textColor']
  ];
  @endphp
@endforeach

<div class="card-body" style="position: relative;">
  @foreach($listcolor as $idx => $row)
  <div>
    <div style="width:10px;height: 10px; background: {{ $row['bgColor'] }}; border: 1px solid {{ $row['borderColor'] }}; color: {{ $row['textColor'] }}; display: inline-block;"></div> {{ $row['label'] }}
  </div>
  @endforeach
  <div id='calendar-container'>
    <div id='calendar'></div>
  </div>
</div>

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
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      height: 'parent',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      defaultView: 'dayGridMonth',
      defaultDate: '{{ date("Y-m-d") }}',
      navLinks: true, // can click day/week names to navigate views
      editable: false,
      displayEventTime: false,
      eventLimit: true, // allow "more" link when too many events
      events: {!! json_encode($list_arr) !!},
      eventRender: function (info) {
        if($(info.el).hasClass('fc-event')) {
          $(info.el).attr("data-id", $(info.el).attr('href').replace('#',''));
          $(info.el).attr("data-toggle", 'modal');
          $(info.el).attr("data-target", '#detailModal');
        }
      }
    });

    calendar.render();
  });
$(function() {
});
</script>
