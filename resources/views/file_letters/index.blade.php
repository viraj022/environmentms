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
                                @else
                                    <span class="badge badge-success text-wrap"
                                        style="font-size: 15px;">{{ $letter->letter_status }}</span></td>
                            @endif

                            <td>
                                <a href="{{ route('view.file.letter', $letter->id) }}" class="btn btn-success btn-sm">
                                    View & Print
                                </a>
                                @if ($letter->letter_status == 'Incomplete')
                                <a href="{{ route('file.letter.edit.view', ['client_id' => $letter->client_id, 'letter_id' => $letter->id]) }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <a href="{{ route('view.file.letter.minutes', $letter->id) }}"
                                    class="btn btn-secondary btn-sm">
                                    Add Minutes
                                </a>
                                <a href="{{ route('view.file.letter.assign', $letter->id) }}" class="btn btn-info btn-sm">
                                    Assign Letter
                                </a>
                                    <form action="{{ route('store.letter.completed', $letter->id) }}" method="POST"
                                        class="d-inline" id="complete_form">
                                        @csrf
                                        <button class="btn btn-success btn-sm" type="button"
                                            id="complete">Complete</button>
                                    </form>
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
                    Swal.fire('Saved!', '', 'success')
                } else {
                    return false;
                }
            });
        });
    </script>
@endsection
