<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Application Details</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/fancybox/fancybox.css') }}">
    <style>
        @media print {

            /* ISO Paper Size */
            @page {
                size: A4 portrait;
                margin: 0.5in 0.5in;
            }

            #printBtn,
            #attachmentCard {
                display: none;
            }


        }
    </style>
</head>

<body>
    <div id="wrapper">
        <div id="appheadertitle">
            @yield('attachments')
            @yield('appheadertitle')
        </div>
        <div id="footer">
            <button type="button" class="btn btn-primary mx-5 my-4" id="printBtn">Print</button>
            <button type="button" class="btn btn-primary mx-3" id="pdfBtn">Download</button>
        </div>
        <div id="contents">
            @yield('contents')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="{{ asset('plugins/fancybox/fancybox.umd.js') }}"></script>
    <script>
        $(document).on('click', "#printBtn", function() {
            print();
        });
    </script>
</body>

</html>
