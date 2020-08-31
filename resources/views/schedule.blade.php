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
                        <div class="card-body">
                            <div class="form-group">
                                <label>Assistant Director*</label>
                                <select id="getAsDirect" class="form-control form-control-sm">
                                    <option value="0">Loading..</option>
                                </select>
                                <div id="valAsDirect" class="d-none"><p class="text-danger">Field is required</p></div>
                            </div>
                            <div class="form-group">
                                <label>Environment Officer*</label>
                                <select id="getEnvOfficer" class="form-control form-control-sm">
                                    <option value="0">Loading..</option>
                                </select>
                                <div id="valEnvOfficer" class="d-none"><p class="text-danger">Field is required</p></div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Events</h4>
                        </div>
                        <div class="card-body">
                            <!-- the events -->
                            <div id="external-events">
                                <p class='text-success'>Loading...</p>
                                <!--                                <div class="external-event bg-warning">Telecommunication</div>
                                                                <div class="external-event bg-info">Another [1]</div>
                                                                <div class="external-event bg-primary">Another [2]</div>
                                                                <div class="external-event bg-danger">Another [3]</div>-->
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
<script src="../../js/ScheduleJS/main_schedule.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    $(function () {
        //Load AssDir Combo
        loadAssDirCombo(function () {
            loadEnvOfficerCombo($('#getAsDirect').val(), function (rest) {
                setInspectionNeededApi($('#getEnvOfficer').val(), function () {
                });
                loadCalenderApi($('#getEnvOfficer').val(), function (event) {//get all events from db
                    console.log(event);
                    calendar.addEventSource(event); //Passing Funtion Array Into This(event)
                });
            });
        });
        $("#getAsDirect").change(function () {
            loadEnvOfficerCombo($('#getAsDirect').val(), function (rest) {
            });
        });

        // initialize the calendar--
        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendarInteraction.Draggable;
        var containerEl = document.getElementById('external-events');
        var calendarEl = document.getElementById('calendar');
        // initialize the external events
        // -----------------------------------------------------------------

        new Draggable(containerEl, {
            itemSelector: '.external-event',
            eventData: function (eventEl) {
                return {
                    title: eventEl.innerText,
                    backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                    borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                    textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
//                    url: 'https://ceytechsystemsolutions.com/',
                    allDay: false,
                    id: eventEl.getAttribute('data-id'),
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
            events: '',
//                    [
//                {
//                    title: 'All Day Event',
//                    start: new Date(y, m, 1),
//                    backgroundColor: '#f56954', //red
//                    borderColor: '#f56954', //red
//                    allDay: false
//                },
//                {
//                    title: 'Long Event',
//                    start: new Date(y, m, d - 5),
//                    end: new Date(y, m, d - 2),
//                    backgroundColor: '#f39c12', //yellow
//                    borderColor: '#f39c12' //yellow
//                },
//                {
//                    title: 'Meeting',
//                    start: new Date(y, m, d, 10, 30),
//                    allDay: false,
//                    backgroundColor: '#0073b7', //Blue
//                    borderColor: '#0073b7' //Blue
//                },
//                {
//                    title: 'Lunch',
//                    start: new Date(y, m, d, 12, 0),
//                    end: new Date(y, m, d, 14, 0),
//                    allDay: false,
//                    backgroundColor: '#00c0ef', //Info (aqua)
//                    borderColor: '#00c0ef' //Info (aqua)
//                },
//                {
//                    title: 'Birthday Party',
//                    start: new Date(y, m, d + 1, 19, 0),
//                    end: new Date(y, m, d + 1, 22, 30),
//                    allDay: false,
//                    backgroundColor: '#00a65a', //Success (green)
//                    borderColor: '#00a65a' //Success (green)
//                },
//                {
//                    title: 'Click for Google',
//                    start: new Date(y, m, 28),
//                    end: new Date(y, m, 29),
//                    url: 'http://google.com/',
//                    backgroundColor: '#3c8dbc', //Primary (light-blue)
//                    borderColor: '#3c8dbc' //Primary (light-blue)
//                }
//            ],
            editable: false,
            eventResizableFromStart: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            drop: function (info) {
                // is the "remove after drop" checkbox checked?
                info.draggedEl.parentNode.removeChild(info.draggedEl);
            },
            eventReceive: function (info) {
                var frmValues = {"remark": "", "schedule_date": info.event.start.toISOString().slice(0, 10)};
                if (isNaN(parseInt(info.event.id))) {
                    return false;
                }
                PersonalInspectionCreateApi(info.event.id, frmValues, function (rep) {
                    show_mesege(rep);
                    if (rep.message == 'true') {
                    } else {
                        inspectionsByDateAPI($(this).data('date'), $('#getEnvOfficer').val(), function () {
                        });
                    }
                });
            }
        });
        calendar.render();
        //Show Modal By Clicking Dates On Calender
        $(document).ready(function () {
            $('.fc-past,.fc-future,.fc-today').click(function () {
                inspectionsByDateAPI($(this).data('date'), $('#getEnvOfficer').val(), function () {
                });
                $('#modal-xl').modal('show');
                $('#modalTitle').html('Appoinment - ' + $(this).data('date'));
            });
        });
    });
</script>
@endsection
