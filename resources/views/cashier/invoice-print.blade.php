<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        html,
        body {
            font-family: 'Tahoma', 'Arial', 'Ubuntu', serif, sans-serif;
            font-weight: 400;
            font-size: 14px;
        }

        .container-fluid {
            width: 100%;
        }

        table.table {
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }

        .table tr,
        .table th,
        .table td {
            border: 1px solid #000;
            padding: 0.5em;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        @media print {

            /* ISO Paper Size */
            @page {
                orientation: portrait;
                height: 14cm;
                width: 21.5cm;
                margin: .5cm 1cm .5cm .5cm;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <strong style="font-size: 17px;">Provincial Environmental Authority</strong> <br>
                    <strong>North Western Province</strong> <br>
                    <span>0372225236 | pentanwp@gmail.com</span> <br>
                    <strong>:: Cash Reciept ::</strong>
                </div>
                <p>

                    VAT Registration No. 409216765-7000 <span style="margin-left: 25px;">N.B.T. No.
                        409216765-9000</span> <br> <br>
                    Recipt No. : {{ $transaction->id }}
                    <span style="margin-left: 35px">Date
                        :{{ Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}</span>
                    <span style="margin-left: 35px"> Received From : {{ $invoice->name }} </span>

                </p>

                <section>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Amount(Rs)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction->transactionItems as $transactionItem)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transactionItem->payment->name }}</td>
                                    <td class="text-end">{{ number_format($transactionItem->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" style="text-align: left">Total</td>
                                <td class="text-end">{{ number_format($invoice->sub_total, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left">VAT</td>
                                <td class="text-end">{{ number_format($invoice->vat_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left">NBT</td>
                                <td class="text-end">{{ number_format($invoice->nbt_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left">Net Total</td>
                                <td class="text-end">{{ number_format($invoice->amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </section>
                <div style="margin-top: 30px;">
                    Signature & Designation: .......................
                </div>
            </div>
        </div>
    </div>
    <script>
        print();
    </script>
</body>

</html>
