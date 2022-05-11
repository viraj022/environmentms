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
<!-- Theme style -->
<link rel="stylesheet" href="/dist/css/adminlte.min.css">
<style>
    /* SHADE DAYS IN THE PAST */
    td.fc-day.fc-past {
        background-color: #EEEEEE;
    }

    .tooltip-hoover{
      color: #fff;
      background-color: #5a6268;
      border-color: #545b62;
    }
    
</style>
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
                    <div class="card card-gray">
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
                <div class="card card-gray">
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
                                    <th>File No</th>
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
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-file-data">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalUserInfo">Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body table-responsive" style="height: 450px;">
                        <table class="table table-condensed" id="tblUserData">
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
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
<script src="https://unpkg.com/@popperjs/core@2"></script>
<!-- AdminLTE App -->
<script>
    $(function () {
        // $('[data-toggle="tooltip"]').tooltip();
        // initialize the calendar--
        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendarInteraction.Draggable;
        var containerEl = document.getElementById('external-events');
        var calendarEl = document.getElementById('calendar');
        // initialize the external events
        // -----------------------------------------------------------------
        //Load AssDir Combo
        loadAssDirCombo(function () {
            loadEnvOfficerCombo($('#getAsDirect').val(), function (rest) {
                setInspectionNeededApi($('#getEnvOfficer').val(), function () {
                });
                loadCalenderApi($('#getEnvOfficer').val(), function (event) {//get all events from db
                    calendar.addEventSource(event); //Passing Funtion Array Into This(event)
                });
            });
        });
        //Function when change Assist Dir Combo
        $(document).on('change', '#getAsDirect', function () {
            calendar.removeAllEvents(); //clear calender before adding events
            loadEnvOfficerCombo($('#getAsDirect').val(), function () {
                setInspectionNeededApi($('#getEnvOfficer').val(), false);
                loadCalenderApi($('#getEnvOfficer').val(), function (event) {//get all events from db
                    if ($('#getEnvOfficer').val() == '4A616B65') {
                        calendar.getEventSources()[0].remove();
                    } else {
                        calendar.addEventSource(event); // This will add all events
                    }
                });
            });
        });

        //Change EnvOfficer Combo
        $("#getEnvOfficer").change(function () {
            calendar.removeAllEvents();
            setInspectionNeededApi($('#getEnvOfficer').val(), false);
            loadCalenderApi($('#getEnvOfficer').val(), function (event) {//get all events from db
                calendar.getEventSources()[0].remove(); // This will remove all events from calender
                calendar.addEventSource(event); // This will add all events
            });
        });



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
            editable: false,
            eventResizableFromStart: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            drop: function (info) {
                // is the "remove after drop" checkbox checked?
                info.draggedEl.parentNode.removeChild(info.draggedEl);
            },
            /* This constrains it to today or later */
            eventConstraint: {
                start: moment().format('YYYY-MM-DD'),
                end: '2200-01-01' // hard coded goodness unfortunately
            },
            eventReceive: function (info) {
                var env_officer_id = $('#getEnvOfficer').val(); //Env Officer ID
                var date = new Date(info.event.start); //Unformatted Date
                var returnDate = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate(); //Format Date Manually
                var frmValues = {"remark": "", "environment_officer_id": env_officer_id, "schedule_date": returnDate};
                if (isNaN(parseInt(info.event.id))) {
                    return false;
                }
                personalInspectionCreateApi(info.event.id, frmValues, function (rep) {
                    show_mesege(rep);
                    if (rep.message == 'true') {
                    } else {
                        inspectionsByDateAPI($(this).data('date'), $('#getEnvOfficer').val(), function () {
                        });
                    }
                });
            }
        });
        calendar.render(); //<-- Render Calender
        //Show Modal By Clicking Dates On Calender
        $(document).ready(function () {
            $(document).on('click', '.fc-past,.fc-future,.fc-today', function () { // Remove ".fc-future" to prevent clicking future dates
                inspectionsByDateAPI($(this).data('date'), $('#getEnvOfficer').val(), function () {
                });
                $('#modal-xl').modal('show');
                $('#modalTitle').html('Appoinment - ' + $(this).data('date'));
                $('#modalTitle').data('inspecdate', $(this).data('date'));
            });

            $(document).on('click', '.external-event', function () {//Event Modal
                displayClientDataFromEvent($(this).attr("data-id"), function () {
                });
                $('#modalUserInfo').html($(this).text());
                $('#modal-file-data').modal('show');
            });

        });

        //Remove Inspection Btn After Clicking Date On Calender
        $(document).on('click', '.removeInspecBtn', function () {
            InspectionRemoveApi($(this).val(), function (resp) {
                show_mesege(resp);
                calendar.removeAllEvents(); //clear calender before adding events
                if (resp.id == 1) {
                    inspectionsByDateAPI($('#modalTitle').data('inspecdate'), $('#getEnvOfficer').val(), false);
                    setInspectionNeededApi($('#getEnvOfficer').val(), false);
                    loadCalenderApi($('#getEnvOfficer').val(), function (event) {//get all events from db
                        calendar.getEventSources()[0].remove(); // This will remove all events from calender
                        calendar.addEventSource(event); // This will add all events
                    });
                }
            });
        });

    });
</script>
@endsection
