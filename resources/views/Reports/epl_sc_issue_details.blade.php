<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="api-token" content="{{ auth()->user()->api_token }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EPL Report | PEA - North Western Province</title>
    <link rel="stylesheet" type="text/css" href="/dataTable/datatables.min.css" />
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <center>
        <h1>EPL/CS Report </h1>
        <h5>{{ $data['filterLable'] }}</h5>
    </center>
    <h4>(filter By Issue date)</h4>
    {{-- @dump($data['results'][2]); --}}
    <table class="table cell-border compact stripe">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Application submited</th>
                <th>Client</th>
                <th>NIC</th>
                <th>Client Address</th>
                <th>Client Tel</th>
                <th>Industry Name</th>
                <th>Br No</th>
                <th>Count</th>
                <th>Insustry Address</th>
                <th>Insustry Tel</th>
                <th>Insustry Category</th>
                <th>Insustry Scale</th>
                <th>AD</th>
                <th>EO</th>
                <th>Zone</th>
                <th>PS</th>
                <th>File No</th>
                <th>SC No</th>
                <th>EPL No</th>
                <th>Certificate No</th>
                <th>Issued At</th>
                <th>Expire At</th>
                <th>Inspection Fee</th>
                <th>Inspection invoice</th>
                <th>License Fee</th>
                <th>License invoice</th>
                <th>Fine</th>
                <th>Fine invoice</th>
                <th>Total</th>
                <th>Certificate Collected At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['results'] as $indexKey => $row)
                <tr>
                    <td>{{ $indexKey + 1 }}.</td>
                    <td>{{ $row['app_submitted_date'] }}</td>
                    <td>{{ $row['client_name'] }}</td>
                    <td>{{ $row['nic'] }}</td>
                    <td>{{ $row['client_address'] }}</td>
                    <td>{{ $row['client_phone'] }}</td>
                    <td>{{ $row['industry_name'] }}</td>
                    <td>{{ $row['br_no'] }}</td>
                    <td>{{ $row['count'] }}</td>
                    <td>{{ $row['industry_address'] }}</td>
                    <td>{{ $row['industry_phone'] }}</td>
                    <td>{{ $row['industry_category'] }}</td>
                    <td>{{ $row['industry_category_type'] }}</td>
                    <td>{{ $row['ad'] }}</td>
                    <td>{{ $row['eo'] }}</td>
                    <td>{{ $row['district'] }}</td>
                    <td>{{ $row['pra_sb'] }}</td>
                    <td><a href="/industry_profile/id/{{ $row['client_id'] }}"
                            target="_blank">{{ $row['file_no'] }}</a></td>
                    <td>{{ $row['sc_no'] }}</td>
                    <td><a href="/epl_payments/id/{{ $row['epl_id'] }}/type/epl"
                            target="_blank">{{ $row['epl_no'] }}</a></td>
                    <td>{{ $row['cert_no'] }}</td>

                    <td>{{ $row['cert_issue_date'] }}</td>
                    <td>{{ $row['cert_exp_date'] }}</td>

                    <td style="text-align: right">{{ number_format($row['fee_inspection'], 2) }}</td>
                    <td style="text-align: right">{{ $row['inv_inspection']['invoice_no'] ?? '' }}
                        {{ $row['inv_inspection']['invoice_date'] ?? '' }}</td>

                    <td style="text-align: right">{{ number_format($row['fee_license'], 2) }}</td>
                    <td style="text-align: right">{{ $row['inv_license']['invoice_no'] ?? '' }}
                        {{ $row['inv_license']['invoice_date'] ?? '' }}</td>

                    <td style="text-align: right">{{ number_format($row['fee_fine'], 2) }}</td>
                    <td style="text-align: right">{{ $row['inv_fine']['invoice_no'] ?? '' }}
                        {{ $row['inv_fine']['invoice_date'] ?? '' }}</td>

                    <td style="text-align: right">{{ number_format($row['fee_total'], 2) }}</td>

                    <td>{{ $row['license_payment_date'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script src="/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/dataTable/datatables.min.js"></script>
    <script type="text/javascript" src="/js/image.js"></script>
    <script>
        var img =
            // $('.table').DataTable();
            $(document).ready(function() {
                // alert(123);
                $('.table').DataTable({
                    // colReorder: true,
                    responsive: false,
                    select: true,
                    dom: "Bfrtip",
                    // buttons: ["csv", "excel", "print",],
                    buttons: [{
                        extend: 'print',
                        title: '',
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt')
                                .prepend(
                                    '<center><H1>PEA Report</h1></center><img src=' +
                                    img +
                                    ' style="position:absolute; filter: grayscale(100%); opacity: 0.5; top:0; left:0;" />'
                                );
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }, "excel", "csv"],
                    layout: {
                        topStart: {
                            buttons: ['colvis']
                        }
                    }
                });
            });
    </script>
</body>

</html>
