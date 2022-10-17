@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
    <link rel="stylesheet" type="text/css" href="/dataTable/datatables.min.css" />
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="mb-3">Completed Files</h1>
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Industry Name</th>
                                        <th>File no/ SC/ EPL</th>
                                        <th>License no</th>
                                        <th> Pradeshiya sabhawa</th>
                                        <th>File category</th>
                                        <th>File subcategory</th>
                                        <th>Assistant director</th>
                                        <th>Issue date</th>
                                        <th>Expire date</th>
                                        <th>Director approval date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($completedFiles as $completeFile)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $completeFile->industry_name }}</td>
                                            <td>
                                                {{ $completeFile->file_no }}
                                                @if (isset($completeFile->siteClearenceSessions) && $completeFile->siteClearenceSessions->isNotEmpty())
                                                    <br> {{ $completeFile->siteClearenceSessions->first()->code }}
                                                @endif
                                                @if (isset($completeFile->epls) && $completeFile->epls->isNotEmpty())
                                                    <br> {{ $completeFile->epls->first()->code }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($completeFile->certificates) && $completeFile->certificates->isNotEmpty())
                                                    {{ $completeFile->certificates->first()->cetificate_number }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $completeFile->pradesheeyasaba->name }}</td>
                                            <td>{{ $completeFile->industryCategory->name }}</td>
                                            @if (isset($completeFile->industry_sub_category))
                                                <td>{{ $completeFile->industry_sub_category }}</td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            <?php
                                            $str = $completeFile->pradesheeyasaba->zone->name;
                                            $replace = preg_replace('/^(Inspection Area of)|(and the team)$/i', '', $str);
                                            ?>
                                            <td>{{ trim($replace) }}</td>
                                            <td>
                                                @if (isset($completeFile->certificates) && $completeFile->certificates->isNotEmpty())
                                                    {{ Carbon\Carbon::parse($completeFile->certificates->first()->issue_date)->format('Y-m-d') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($completeFile->certificates) && $completeFile->certificates->isNotEmpty())
                                                    {{ $completeFile->certificates->first()->expire_date }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="13">No available completed files</td>
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
