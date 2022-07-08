@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')

@section('content')
    <style>
        #letter {
            width: 210mm;
            height: 297mm;
            border: 1px solid #212121;
            margin: 30px auto;
            box-shadow: 0px 0px 15px #000;
            background-color: #ffffff;
            padding: 1in 1in 1in 1in;
            font-size: 12pt;
        }

        #print {
            background-color: rgb(153, 153, 240);
            border-radius: 10px;
            border: none;
            margin-left: 30px;
            padding: 10px;
            font-size: 15px;
        }

        @media print {
            .print_hidden {
                display: none;
            }
        }
    </style>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <h1>Letter View</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div id="print_letter" class="print_hidden">
                <button id="print">Print Letter</button>
                <a href="{{ route('file.letter.view', $letter->client_id) }}" class="btn btn-success"
                    style="margin-right: 20px; float: right; padding: 10px;">Back to Letters</a>
            </div>
            <div id="letter">
                {!! $letter->letter_content !!}
            </div>
        </div>
    </section>

    <script>
        function printLetter() {
            var printContent = document.getElementById('letter');
            var WinPrint = window.open('', '', 'width=900,height=650');
            WinPrint.document.write(printContent.innerHTML);
            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            WinPrint.close();
        }

        document.getElementById("print").addEventListener("click", function() {
            printLetter();
        });
    </script>
@endsection
