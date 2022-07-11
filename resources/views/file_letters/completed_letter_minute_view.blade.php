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
                    <h1>Completed Letter Minute</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="col-lg-10">
                <table class="table table-bordered">
                    <colgroup>
                        <col style="width: 10%;">
                        <col style="width: 50%;">
                        <col style="width: 20%;">
                        <col style="width: 20%;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Minute Descriptions</th>
                            <th>User</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($letterMinutes as $letterMinute)
                        <tr>
                            <td style="width: 10%;">{{$loop->iteration}}</td>
                            <td style="word-wrap: break-word; word-break: break-all;">{{$letterMinute->description}}</td>
                            <td style="width: 20%;">{{$letterMinute->user->user_name }}</td>
                            <td style="width: 20%;">{{$letterMinute->updated_at }}</td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4">No Minute Records</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    <section>
@endsection
