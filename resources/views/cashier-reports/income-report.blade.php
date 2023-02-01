<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        @media print {

            /* ISO Paper Size */
            @page {
                orientation: Landscape;
            }

            #printBtn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <button type="button" class="btn btn-primary mx-5 my-4" id="printBtn">Print</button>
    <center>
        <h3>Revenue / Receipt Report </h3>
        <h5>Period From: {{ $start_date }} To: {{ $end_date }}</h5>
    </center>

    {{-- @dd($paymentTypes) --}}

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th rowspan="2">Date</th>
                <th rowspan="2">Receipt No</th>
                @foreach ($paymentTypes as $type)
                    <th {!! $type['is_grouped'] ? 'rowspan="2"' : '' !!} {!! ($type['is_grouped']
                            ? ''
                            : count($type['payments']) > 0)
                        ? 'colspan="' . count($type['payments']) . '"'
                        : '' !!}>
                        {!! $type['name'] !!}</th>
                @endforeach
                <th rowspan="2">Total (Without Tax)</th>
                <th rowspan="2">VAT</th>
                <th rowspan="2">NBT</th>
                <th rowspan="2">Other Tax</th>
                <th rowspan="2">Total (with Tax)</th>
            </tr>
            <tr>
                @foreach ($paymentTypes as $type)
                    @if (!$type['is_grouped'])
                        @foreach ($type['payments'] as $tp)
                            <th>{{ $tp['name'] }}</th>
                        @endforeach
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_date }}</td>
                    <td>{{ $invoice->invoice_id }}</td>
                    @foreach ($paymentTypes as $type)
                        @if (!$type['is_grouped'])
                            @foreach ($type['payments'] as $tp)
                            @endforeach
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script>
        $(document).on('click', "#printBtn", function() {
            print();
        });
    </script>
</body>

</html>
