@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
<style>
    .A4-paper {
    height: 842px;
    width: 595px;
    /* to centre page on screen*/
    margin-left: auto;
    margin-right: auto;
}
</style>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <section id="warn_letter" class="A4-paper mt-5" style="width: 21cm; height: 29.7cm;">
                <div>
                        <p style="font-size: 21px" id="letter_title"></p>
                </div>
                <div>
                    <p style="text-align: right; font-size: 21px"> {{ dd($warn_let_data->created_at) }} </p>
                </div>
                <div>
                    <p style="text-decoration:underline; font-size: 24px; text-align: center">පාරිසරික ආරක්ෂණ බලපත්‍රය අළුත් කිරීම - site address, industry category</p>
                </div>
                <div style="font-size: 21px">
                        <p>
                            උක්ත ලිපිනයයහි සඳහන් කර්මාන්තය සඳහා මෙම අධිකාරිය විසින් නිකුත් කරන ලද <................ > 
                            අංක දරණ බලපත්‍රය <..........> දින කල් ඉකුත්වීමට නියමිතය. බලපත්‍රය අළුත් කීරීම සදහා “පාරිසරික
                            ආරක්ෂණ බලපත්‍රය වාර්ෂිකව අළුත් කීරීම සඳහා වූ ඉල්ලුම් පත්‍රය” ඉදිරිපත් කල යුතු බව කාරුණිකව
                            දන්වමි.
                        </p>
                        <p class="mt-1">
                            වලංගු පාරිසරික ආරක්ෂණ බලපත්‍රයක් නොමැතිව කර්මානතයක් පවත්වාගෙන යාම 1990 ළංක 12 
                            දරණ වයඹ පළාත් පාරිසරික ප්‍රඥප්තතිය යටතේ දඩුලම් ලැබිය හැකි වරදක් බව කාරුණිකව දන්වා සිටිමි. 
                        </p>
                        <p class="mt-1">
                            දැනටමත් ඔබ විසින් අයදුම්පතක් ඉදිරිපත් කර ඇත්නම්. මෙය නොසලකාහරින මෙන් දන්වා සිටිමි.
                        </p>
                </div>
                <div>
                    <p style="font-size: 18px">
                        <img src="" /><br>
                        එස්.කේ.ඒ. ලේනදූව,<br>
                        අධ්‍යක්ෂ,<br>
                        පළාත් පරිසර අධිකාරිය,<br>
                        කුරුණෑගල
                    </p>
                </div>
            </section>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('pageScripts')
<script>
    var address = '{{ $warn_let_data->client->address }}';

    var address_array = address.split(",");

    console.log(address);
    // var html='';
    // $.each(address_array, function(index, item) {
    // });
    // $('#letter_title').html(html);
</script>
@endsection
