@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')<!-- This section didnt work for me -->
<!-- fullCalendar -->
<link rel="stylesheet" href="../plugins/fullcalendar/main.min.css">
<link rel="stylesheet" href="../plugins/fullcalendar-daygrid/main.min.css">
<link rel="stylesheet" href="../plugins/fullcalendar-timegrid/main.min.css">
<link rel="stylesheet" href="../plugins/fullcalendar-bootstrap/main.min.css">
@endsection

@section('content')
@if($pageAuth['is_read']==1 || false)
<section class="content-header">

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Schedule</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="sticky-top mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Events</h4>
                        </div>
                        <div class="card-body">
                            <!-- the events -->
                            <div id="external-events">
                                <div class="external-event bg-success">EPL</div>
                                <div class="external-event bg-warning">Telecommunication</div>
                                <div class="external-event bg-info">Another [1]</div>
                                <div class="external-event bg-primary">Another [2]</div>
                                <div class="external-event bg-danger">Another [3]</div>
                                <!--                                <div class="checkbox">
                                                                    <label for="drop-remove">
                                                                        <input type="checkbox" id="drop-remove">
                                                                        remove after drop
                                                                    </label>
                                                                </div>-->
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card d-none">
                        <div class="card-header">
                            <h3 class="card-title">Create Event</h3>
                        </div>
                        <div class="card-body">
                            <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                              <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                                <ul class="fc-color-picker" id="color-chooser">
                                    <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                                    <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                                    <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                                    <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                                    <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                                </ul>
                            </div>
                            <!-- /btn-group -->
                            <div class="input-group">
                                <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                                <div class="input-group-append">
                                    <button id="add-new-event" type="button" class="btn btn-primary">Add</button>
                                </div>
                                <!-- /btn-group -->
                            </div>
                            <!-- /input-group -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-body p-0">
                        <!-- THE CALENDAR -->
                        <div id="calendar"></div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle">Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body table-responsive" style="height: 450px;">
                        <table class="table table-condensed" id="tblSchedules">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th style="width: 140px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</section>
@endif
@endsection



@section('pageScripts')
<!-- Page script -->

<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/fullcalendar/main.min.js"></script>
<script src="../../plugins/fullcalendar-daygrid/main.min.js"></script>
<script src="../../plugins/fullcalendar-timegrid/main.min.js"></script>
<script src="../../plugins/fullcalendar-interaction/main.min.js"></script>
<script src="../../plugins/fullcalendar-bootstrap/main.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/adminlte.min.js"></script>
<script src="../../dist/js/demo.js"></script>
<script src="../../js/zonejs/submit.js"></script>
<script src="../../js/zonejs/get.js"></script>
<script src="../../js/zonejs/update.js"></script>
<script src="../../js/zonejs/delete.js"></script>
<!-- AdminLTE App -->
<script>
    $(function () {
        /*
         // initialize the external events
         function ini_events(ele) {
         ele.each(function () {
         var eventObject = {
         title: $.trim($(this).text()) // use the element's text as the event title
         }
         
         // store the Event Object in the DOM element so we can get to it later
         $(this).data('eventObject', eventObject)
         
         // make the event draggable using jQuery UI
         $(this).draggable({
         zIndex: 1070,
         revert: true, // will cause the event to go back to its
         revertDuration: 0  //  original position after the drag
         })
         
         })
         }
         
         ini_events($('#external-events div.external-event'))
         */
        // initialize the calendar--
        //Date for the calendar events (dummy data)
        var date = new Date()
        var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendarInteraction.Draggable;

        var containerEl = document.getElementById('external-events');
        var checkbox = document.getElementById('drop-remove');
        var calendarEl = document.getElementById('calendar');

        // initialize the external events
        // -----------------------------------------------------------------

        new Draggable(containerEl, {
            itemSelector: '.external-event',
            eventData: function (eventEl) {
                console.log(eventEl);
                return {
                    title: eventEl.innerText,
                    backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                    borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                    textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
//                    url: 'https://ceytechsystemsolutions.com/',
                    allDay: false,
                    eventResizableFromStart: false,
                    eventDurationEditable: false
                };
            }
        });

        var calendar = new Calendar(calendarEl, {
            plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid'],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            //Random default events
            events: [
                {
                    title: 'All Day Event',
                    start: new Date(y, m, 1),
                    backgroundColor: '#f56954', //red
                    borderColor: '#f56954', //red
                    allDay: false
                },
                {
                    title: 'Long Event',
                    start: new Date(y, m, d - 5),
                    end: new Date(y, m, d - 2),
                    backgroundColor: '#f39c12', //yellow
                    borderColor: '#f39c12' //yellow
                },
                {
                    title: 'Meeting',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false,
                    backgroundColor: '#0073b7', //Blue
                    borderColor: '#0073b7' //Blue
                },
                {
                    title: 'Lunch',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false,
                    backgroundColor: '#00c0ef', //Info (aqua)
                    borderColor: '#00c0ef' //Info (aqua)
                },
                {
                    title: 'Birthday Party',
                    start: new Date(y, m, d + 1, 19, 0),
                    end: new Date(y, m, d + 1, 22, 30),
                    allDay: false,
                    backgroundColor: '#00a65a', //Success (green)
                    borderColor: '#00a65a' //Success (green)
                },
                {
                    title: 'Click for Google',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    url: 'http://google.com/',
                    backgroundColor: '#3c8dbc', //Primary (light-blue)
                    borderColor: '#3c8dbc' //Primary (light-blue)
                }
            ],
            editable: false,
            eventResizableFromStart: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            drop: function (info) {
                // is the "remove after drop" checkbox checked?
                info.draggedEl.parentNode.removeChild(info.draggedEl);
            }
        });

        calendar.render();
        // $('#calendar').fullCalendar()

        /*    // ADDING EVENTS /
         var currColor = '#3c8dbc' //Red by default
         //Color chooser button
         var colorChooser = $('#color-chooser-btn')
         $('#color-chooser > li > a').click(function (e) {
         e.preventDefault()
         //Save color
         currColor = $(this).css('color')
         //Add color effect to button
         $('#add-new-event').css({
         'background-color': currColor,
         'border-color': currColor
         })
         })
         $('#add-new-event').click(function (e) {
         e.preventDefault()
         //Get value and make sure it is not null
         var val = $('#new-event').val()
         if (val.length == 0) {
         return
         }
         
         //Create events
         var event = $('<div />')
         event.css({
         'background-color': currColor,
         'border-color': currColor,
         'color': '#fff'
         }).addClass('external-event')
         event.html(val)
         $('#external-events').prepend(event)
         
         //Add draggable funtionality
         ini_events(event)
         
         //Remove event from text input
         $('#new-event').val('')
         })
         */
        $('.fc-past,.fc-future,.fc-today').click(function () {
            $('#modal-xl').modal('show');
            $('#modalTitle').html('Appoinment - ' + $(this).data('date'));
        });

    })
</script>
@endsection
