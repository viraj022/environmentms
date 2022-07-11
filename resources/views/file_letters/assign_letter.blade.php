@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <h1>Assign File Letters</h1>
                </div>
                <div class="col-lg-12">
                    <a href="{{ route('file.letter.view', $letter->client_id) }}" class="btn btn-success"
                        style="margin-right: 20px; float: right; padding: 10px;">Back to Letters</a>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-9">
                <div class="card card-gray">
                    <div class="card-header">
                        User assignment for the letter
                    </div>
                    <div class="card-body">
                        <form action="{{ route('store.file.letter.assign', $letter->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <label>User Level: </label>
                                <div class="form-group col-md-2">
                                    <select id="user_level" class="custom-select">
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="user">User: </label>
                                <div class="form-group col-md-3">
                                    <select id="assigned_to_id" name="assigned_to_id" class="custom-select"></select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary form-control"> Assign
                                        To </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-head-fixed text-nowrap" id="forward_history">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Assignee</th>
                            <th>Assignor</th>
                            <th>Assigned Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fileLetterAssigned as $assigned)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $assigned->assignedToUser->user_name }}</td>
                                <td>{{ $assigned->assignedByUser->user_name }}</td>
                                <td>{{ $assigned->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('pageScripts')
    <script>
        function loadUserForLevel() {
            var level = $('#user_level').val();

            ajaxRequest('get', '/api/get_users_for_level/level/' + level, null, function(response) {
                var options = '';

                $.each(response, function(index, value) {
                    options += `<option value="` + value.id + `">` + value.first_name + `- (` + value.name +
                        `) </option>`;
                })
                $('#assigned_to_id	').html(options);

                if (typeof callback == 'function') {
                    callback();
                }
            });
        }

        $('#user_level').change(function() {
            loadUserForLevel();
        });

        $(function() {
            loadUserForLevel();
        });


        @if (session('letter_assigned'))
            Swal.fire('Success', '{{ session('letter_assigned') }}', 'success');
        @endif

    </script>
@endsection
