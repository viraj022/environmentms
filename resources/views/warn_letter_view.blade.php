@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@section('pageStyles')
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->

    <style>
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .A4-paper {
            width: 21cm;
            height: 29.7cm;
            /* to centre page on screen*/
            margin-left: auto;
            margin-right: auto;
            padding: 2cm;
            margin: 1cm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            /* box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); */
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            .A4-paper {
                margin-left: auto;
                margin-right: auto;
                border: initial;
                border-radius: initial;
                width: 21cm;
                height: 29.7cm;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }

            #print-btn {
                display: none;
            }
        }

    </style>
@endsection
@section('content')
    @if ($pageAuth['is_read'] == 1 || false)
        <section class="content">
            <div class="container-fluid">
                <section id="warn_letter" class="A4-paper mt-5">
                    <button onclick="print()" class="btn btn-success float-right" id="print-btn">Print</button>
                    <p style="font-size: 18px; line-height: 1.5" id="letter_address">
                        @forelse ($client_address as $add)
                            <span
                                style="line-height: 0.5cm">{{ $warn_let_data->client->first_name . ' ' . $warn_let_data->client->last_name }}
                                , </span><br>
                            <span style="line-height: 0.5cm">{{ $add }} , </span><br>
                        @empty
                        @endforelse
                        <span
                            style="line-height: 0.5cm">{{ Carbon\Carbon::parse($warn_let_data->created_at)->format('Y-m-d') }}</span><br>
                    </p>
                    <p class="mt-5" style="text-decoration:underline; font-size: 21px; text-align: center">පාරිසරික
                        ආරක්ෂණ බලපත්‍රය අළුත් කිරීම -
                        {{ $warn_let_data->client->industry_address . ' - ' . $warn_let_data->client->industryCategory->name }}
                    </p>
                    <div class="mt-5" style="font-size: 18px">
                        <p class="text-justify">
                            <?php
                            $certificate_count = count($warn_let_data->client->certificates) - 1;
                            ?>
                            උක්ත ලිපිනයෙහි සඳහන් කර්මාන්තය සඳහා මෙම අධිකාරිය විසින් නිකුත් කරන ලද
                            {{ $warn_let_data->client->certificates[$certificate_count]->cetificate_number }}
                            අංක දරණ බලපත්‍රය {{ $warn_let_data->client->certificates[0]->expire_date }} දින කල් ඉකුත්වීමට
                            නියමිතය. බලපත්‍රය අළුත් කීරීම සදහා “පාරිසරික
                            ආරක්ෂණ බලපත්‍රය වාර්ෂිකව අළුත් කීරීම සඳහා වූ ඉල්ලුම් පත්‍රය” ඉදිරිපත් කල යුතු බව කාරුණිකව
                            දන්වමි.
                        </p>
                        <p class="mt-1 text-justify">
                            වලංගු පාරිසරික ආරක්ෂණ බලපත්‍රයක් නොමැතිව කර්මානතයක් පවත්වාගෙන යාම 1990 අංක 12
                            දරණ වයඹ පළාත් පාරිසරික ප්‍රඥප්තතිය යටතේ දඩුලම් ලැබිය හැකි වරදක් බව කාරුණිකව දන්වා සිටිමි.
                        </p>
                        <p class="mt-1 text-justify">
                            දැනටමත් ඔබ විසින් අයදුම්පතක් ඉදිරිපත් කර ඇත්නම්. මෙය නොසලකාහරින මෙන් දන්වා සිටිමි.
                        </p>
                    </div>
                    <div class="mt-5">
                        <p style="font-size: 18px; line-height: 1.5">
                            <img src="" /><br>
                            එස්.කේ.ඒ. ලේනදූව,<br>
                            අධ්‍යක්ෂ,<br>
                            පළාත් පරිසර අධිකාරිය,<br>
                            කුරුණෑගල
                        </p>
                    </div>
                    <div style="margin-top: 60mm">
                        <span><b>Note: This is an authenticated system generated document.</b></span>
                    </div>
                </section>
            </div><!-- /.container-fluid -->
        </section>
    @endif
@endsection

@section('pageScripts')
    <script src="../../dist/js/adminlte.min.js"></script>
@endsection
