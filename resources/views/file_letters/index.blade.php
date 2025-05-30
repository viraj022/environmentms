@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <h1>File Letters</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-10">
                <div class="card">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Letter Title</th>
                                <th>Status</th>
                                <th>Actions</th>
                                <th>Finalized at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fileLetters as $letter)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $letter->letter_title }}</td>
                                    <td>
                                        @if ($letter->letter_status == 'Incomplete')
                                            <span class="badge badge-warning text-wrap"
                                                style="font-size: 15px;">{{ $letter->letter_status }}</span>
                                    </td>
                                @elseif ($letter->letter_status == 'Finalized')
                                    <span class="badge badge-warning text-wrap"
                                        style="font-size: 15px;">{{ $letter->letter_status }}</span>
                                        @else
                                        <span class="badge badge-success text-wrap"
                                        style="font-size: 15px;">{{ $letter->letter_status }}</span></td>
                            @endif

                            <td>
                                <a href="{{ route('view.file.letter', $letter->id) }}" class="btn btn-primary btn-sm">
                                    View & Print
                                </a>

                                @if ($letter->letter_status == 'Finalized' || $letter->letter_status == 'Completed')
                                <a href="{{ route('view.letter.minutes', $letter->id) }}" class="btn btn-success btn-sm">
                                    View Minutes
                                </a>
                                @endif

                                @if ($letter->letter_status == 'Incomplete' || $letter->letter_status == 'Finalized')
                                <a href="{{ route('view.file.letter.minutes', $letter->id) }}"
                                    class="btn btn-secondary btn-sm">
                                    Add Minutes
                                </a>
                                <a href="{{ route('view.file.letter.assign', $letter->id) }}" class="btn btn-info btn-sm">
                                    Assign Letter
                                </a>
                                @endif

                                @if ($letter->letter_status == 'Incomplete')
                                <a href="{{ route('file.letter.edit.view', ['client_id' => $letter->client_id, 'letter_id' => $letter->id]) }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('letter.finalize', $letter->id) }}" method="post" class="d-inline" id="finalize_form">
                                    @csrf
                                    <button class="btn btn-success btn-sm" type="button"
                                    id="finalize">Letter Finalize</button>
                                </form>
                                @endif

                                @if ($letter->letter_status == 'Finalized')
                                <form action="{{ route('store.letter.completed', $letter->id) }}" method="POST"
                                    class="d-inline" id="complete_form">
                                    @csrf
                                    <button class="btn btn-success btn-sm" type="button" id="complete">Complete</button>
                                </form>
                                @endif
                                @if ($letter->letter_status == 'Incomplete')
                                <form action="{{ route('letter.delete', $letter->id) }}" method="post" class="d-inline" id="deleted_form">
                                    @method('delete')
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-danger delete-letter">Delete</button>
                                </form>
                                @endif
                            </td>
                            <td>
                                @if (!empty($letter->finalized_at))
                                {{ Carbon\Carbon::parse($letter->finalized_at)->format('Y-m-d h:i A') }}
                                @endif
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScripts')
<script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script>
        @if (session('letter_update_success'))
            Swal.fire('Success', '{{ session('letter_update_success') }}', 'success');
        @endif
        @if (session('letter_saved'))
            Swal.fire('Success', '{{ session('letter_saved') }}', 'success');
        @endif
        @if (session('letter_saved_error'))
            Swal.fire('Error', '{{ session('letter_saved_error') }}', 'error');
        @endif
        // @if (session('file_letter_completed'))
        //     Swal.fire('Success', '{{ session('file_letter_completed') }}', 'success');
        // @endif

        $('#finalize').click(function(e) {
            Swal.fire({
                title: 'Are you sure You want to finalize this letter?',
                html: 'If you finalize, you can\'t reverse it' ,
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.value === true) {
                    $('#finalize_form').submit();
                    Swal.fire('Letter Finalized!', '', 'success')
                } else {
                    return false;
                }
            });
        });

        $('#complete').click(function(e) {
            Swal.fire({
                title: 'Are you sure You want to complete this letter?',
                html: 'If you complete, you can\'t reverse it' ,
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.value === true) {
                    $('#complete_form').submit();
                    Swal.fire('Letter Completed!', '', 'success')
                } else {
                    return false;
                }
            });
        });

        $('.delete-letter').click(function(e) {
            Swal.fire({
                title: 'Are you sure You want to delete this incomplete letter?',
                html: 'If you delete, you can\'t reverse it' ,
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.value === true) {
                    $('#deleted_form').submit();
                    Swal.fire('Letter Deleted!', '', 'success')
                } else {
                    return false;
                }
            });
        });
    </script>
@endsection
