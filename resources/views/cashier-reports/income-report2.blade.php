<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Income Report</title>

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4-4.6.0/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/datatables.min.css" />
    <style>
        body {
            font-size: 13px;
        }

        @media print {

            /* ISO Paper Size */
            @page {
                orientation: Landscape;
            }

            #wrapper {
                border: none;
                padding: 0px;
                margin: 0px;
            }

            #printBtn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid" id="wrapper">
        <button type="button" class="btn btn-primary mx-5 my-4 d-none" id="printBtn">Print</button>
        <div class="text-center">
            <h3>Revenue / Receipt Report </h3>
            <h5>Period From: {{ $start_date }} To: {{ $end_date }}</h5>
            <input type="text" id="start_date" hidden value="{{ $start_date }}">
            <input type="text" id="end_date" hidden value="{{ $end_date }}">
        </div>

        {{-- @dd($paymentTypes) --}}

        <table class="table table-bordered" id="incomeReport">
            <thead>
                <tr>
                    <th rowspan="2">Date</th>
                    <th rowspan="2">Receipt No</th>
                    <th rowspan="1" colspan="3">Application fee (Rs)</th>
                    <th rowspan="1" colspan="2">Inspection Charge (Rs)</th>
                    <th rowspan="2">Licence fee (Rs)</th>
                    <th rowspan="2">Licence Books (Rs)</th>
                    <th rowspan="2">Fine (Rs)</th>
                    <th rowspan="2">Scheduled waste (Rs)</th>
                    <th rowspan="2">EIA/IEE (Rs)</th>
                    <th rowspan="2">Other Income (Rs)</th>
                    <th rowspan="2">Total (Without Tax) (Rs)</th>
                    <th rowspan="2">VAT (Rs)</th>
                    <th rowspan="2">NBT (Rs)</th>
                    <th rowspan="2">Tax Total (Rs)</th>
                    <th rowspan="2">Total (with Tax) (Rs)</th>
                    <th rowspan="2">Cash</th>
                    <th rowspan="2">Cheque</th>
                    <th rowspan="2">Online</th>
                </tr>
                <tr>
                    <th>Site Cleareance</th>
                    <th>Renewal</th>
                    <th>EPL Application</th>
                    <th>Site Cleareance</th>
                    <th>EPL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr>
                        <td>{{ $row['date'] }}</td>
                        <td>{{ $row['receipt_number'] }}</td>
                        <td class="text-right">{{ number_format($row['apFee_siteClearance'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['apFee_reneaval'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['apFee_eplApplication'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['inspectionCharges_sc'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['inspectionCharges_epl'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['licence_fee'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['licence_books'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['fine'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['waste'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['eia_iee'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['other_income'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['total_without_tax'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['vat'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['nbt'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['tax_total'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['total'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['cash'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['cheque'], 2, '.', '') }}</td>
                        <td class="text-right">{{ number_format($row['online'], 2, '.', '') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-secondary">
                    <th>Total</th>
                    <th>&nbsp;</th>
                    <th class="text-right">{{ number_format($totals['apFee_siteClearance_tot'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['apFee_reneaval_tot'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['apFee_eplApplication_tot'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['inspectionCharges_sc_tot'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['inspectionCharges_epl_tot'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['licence_fee_tot'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['licence_books_tot'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['fine_tot'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['waste_tot'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['eia_iee_tot'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['other_income_tot'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['all_without_tax_total'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['vat'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['nbt'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['all_tax_total'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['all_total'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['cash'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['cheque'], 2, '.', '') }}</th>
                    <th class="text-right">{{ number_format($totals['online'], 2, '.', '') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    {{-- @dd($totals) --}}
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4-4.6.0/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/datatables.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js">
    </script>

    <script src="{{ asset('js/income-report.js') }}" defer></script>
</body>

</html>
