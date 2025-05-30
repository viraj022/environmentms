@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="mb-3">Complains Report</h1>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered" id="compalinsTable">
                                <colgroup>
                                    <col style="width: 5%;">
                                    <col style="width: 10%;">
                                    <col style="width: 10%;">
                                    <col style="width: 10%;">
                                    <col style="width: 15%;">
                                    <col style="width: 10%;">
                                    <col style="width: 15%;">
                                    <col style="width: 10%;">
                                    <col style="width: 10%;">
                                    <col style="width: 10%;">
                                </colgroup>
                                <thead>
                                    <th>#</th>
                                    <th>Complainer name</th>
                                    <th>Pradeshiya sabha</th>
                                    <th>Complaint code</th>
                                    <th>Complainer address</th>
                                    <th>Contact number</th>
                                    <th>Description</th>
                                    <th>Received type</th>
                                    <th>Complained date</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    @forelse ($complains as $complain)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $complain->complainer_name }}</td>
                                            <td>{{ $complain->pradesheeyasaba->name }}</td>
                                            <td>{{ $complain->complainer_code }}</td>
                                            <td>{{ $complain->complainer_address }}</td>
                                            <td>{{ $complain->comp_contact_no }}</td>
                                            <td>{{ $complain->complain_des }}</td>
                                            @if ($complain->recieve_type == 1)
                                                <td>call</td>
                                            @elseif ($complain->recieve_type == 2)
                                                <td>written</td>
                                            @else
                                                <td>verbal</td>
                                            @endif
                                            <td>{{ Carbon\Carbon::parse($complain->created_at)->format('Y-m-d') }}</td>
                                            <td>
                                                @if ($complain->status == 1)
                                                    Confirmed
                                                @elseif ($complain->status == -1)
                                                    Rejected
                                                @elseif ($complain->status == 4)
                                                    Forwarded
                                                @elseif ($complain->status == 0)
                                                    Pending
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">No available completed complains.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScripts')
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#compalinsTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'print'
                ]
            });
        });
    </script>
@endsection
