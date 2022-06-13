@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')


@section('content')
    <div class="container mt-3">
        <center>
            <h5>Report of Site Inspection</h5>
        </center>
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <th width="30%">01).Date</th>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <th>02).Tel</th>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <th rowspan="2">03).Persons Interviewed</th>
                    <td>i</td>
                    <td>ii</td>
                </tr>
                <tr>
                    <td>iii</td>
                    <td>iv</td>
                </tr>
                <tr>
                    <th>04).Inspected By</th>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <th>05).Project Description</th>
                </tr>
                <tr>
                    <td>i). Project Type</td>
                    <td></td>
                    <td>ii).Project Name</td>
                    <td></td>
                </tr>
                <tr>
                    <td>iii). Location</td>
                    <td></td>
                    <td>iv).GPS</td>
                    <td></td>
                </tr>
                <tr>
                    <td>v). Proposed Land</td>
                    <td>a.Extent</td>
                    <td>b.Use</td>
                    <td>c.Ownership</td>
                </tr>
                <tr>
                    <td>vi). Adjoining Lnads</td>
                    <td>N-</td>
                    <td>E-</td>
                </tr>
                <tr>
                    <td></td>
                    <td>S-</td>
                    <td>W-</td>
                </tr>
                <tr>
                    <td>vii). Distance to the residence and of house within </td>
                    <td colspan="3">50m</td>
                </tr>
                <tr>
                    <td>viii). Sensitive areas and public places (with distance) </td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td>ix). Observations & Special issues </td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <th>06). Sketch of the project site </th>
                </tr>
                <tr>
                    <td colspan="4">
                        <img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885__480.jpg" alt="" width="400"
                            height="400">
                    </td>
                </tr>
                <tr>
                    <th>07). Recommendations </th>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Signature:</td>
                </tr>
            </tbody>

        </table>
    </div>
@endsection
