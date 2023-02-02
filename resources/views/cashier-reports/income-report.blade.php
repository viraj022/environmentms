<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        body {
            font-size: 13px;
        }

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
    <div class="text-center">
        <h3>Revenue / Receipt Report </h3>
        <h5>Period From: {{ $start_date }} To: {{ $end_date }}</h5>
    </div>

    {{-- @dd($paymentTypes) --}}

    <table class="table table-bordered">
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
                <th rowspan="2">Tax Total</th>
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
            @foreach ($rows as $row)
                <tr>
                    <td>{{ $row['date'] }}</td>
                    <td>{{ $row['receipt_number'] }}</td>
                    @foreach ($paymentTypes as $type)
                        @if ($type['is_grouped'])
                            <td class="text-end">{{ number_format($row['c_' . $type['id']], 2, '.', '') }}</td>
                        @else
                            @foreach ($type['children'] as $payment_id)
                                <td class="text-end">{{ number_format($row['c_' . $payment_id], 2, '.', '') }}</td>
                            @endforeach
                        @endif
                    @endforeach
                    <td class="text-end">{{ number_format($row['total_without_tax'], 2, '.', '') }}</td>
                    <td class="text-end">{{ number_format($row['vat'], 2, '.', '') }}</td>
                    <td class="text-end">{{ number_format($row['nbt'], 2, '.', '') }}</td>
                    <td class="text-end">{{ number_format($row['tax_total'], 2, '.', '') }}</td>
                    <td class="text-end">{{ number_format($row['total'], 2, '.', '') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="table-secondary">
                <th colspan="2">Total</th>
                @foreach ($paymentTypes as $type)
                    @if ($type['is_grouped'])
                        <th class="text-end">{{ number_format($totals['c_' . $type['id']], 2, '.', '') }}</th>
                    @else
                        @foreach ($type['children'] as $payment_id)
                            <th class="text-end">{{ number_format($totals['c_' . $payment_id], 2, '.', '') }}</th>
                        @endforeach
                    @endif
                @endforeach
                <th class="text-end">{{ number_format($totals['total_without_tax'], 2, '.', '') }}</th>
                <th class="text-end">{{ number_format($totals['vat'], 2, '.', '') }}</th>
                <th class="text-end">{{ number_format($totals['nbt'], 2, '.', '') }}</th>
                <th class="text-end">{{ number_format($totals['tax_total'], 2, '.', '') }}</th>
                <th class="text-end">{{ number_format($totals['total'], 2, '.', '') }}</th>
            </tr>
        </tfoot>
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
