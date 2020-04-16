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

<div class="card-body" style="position: relative;">
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

    @php
      $list_arr = [];
    @endphp

    @foreach($kegiatan as $idx => $row)
      @php
      $list_arr[] = [
        "title" => $row->nama,
        "start" => $row->dari,
        "end" => $row->sampai,
        "url" => "#". $row->id,
      ];
      @endphp
    @endforeach
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
        console.log(info);
        $(info.el).attr("data-id", $(info.el).attr('href').replace('#',''));
        $(info.el).attr("data-toggle", 'modal');
        $(info.el).attr("data-target", '#detailModal');
      }
    });

    calendar.render();
  });
$(function() {
});
</script>
