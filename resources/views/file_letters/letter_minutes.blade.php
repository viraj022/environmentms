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
                    <h1>Letter Minutes</h1>
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
            <form action="{{ route('store.file.letter.minutes', $letter->id) }}" method="post">
                @csrf
                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-dark">
                            <div class="card-header">
                                Minutes
                            </div>
                            <div class="card-body">
                                <input type="text" name="description" id="description" class="form-control"
                                    placeholder="Type Message ...">
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Minute Descriptions</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($letterMinutes as $letterMinute)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $letterMinute->description }}</td>
                                        <td>{{ $letterMinute->user->user_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
    </section>
@endsection

@section('pageScripts')
    <script>
        @if (session('letter_minute_added'))
            Swal.fire('Success', '{{ session('letter_minute_added') }}', 'success');
        @endif
    </script>
@endsection
