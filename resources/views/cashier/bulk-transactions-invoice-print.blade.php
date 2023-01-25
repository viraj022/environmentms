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
                        409216765-9000</span> <span style="margin-left: 25px;">N.W.P.C මු/1 </span> <br> <br>
                    <span> Received From : {{ $invoice->name }} </span>

                </p>

                <section>
                    @foreach ($transactions as $transaction)
                        <div style="margin-top: 10px;">
                            <div style="margin-bottom: 10px;">
                                Recipt No. : {{ $transaction->id }} <br>
                                <span>Date
                                    :{{ Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d') }}</span>
                            </div>
                            <table class="table table-bordered mb-2">
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
                            </table>
                        </div>
                    @endforeach
                    <div style="margin-top: 20px;" id="totalTable">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th colspan="2" style="text-align: left">Total</th>
                                    <td class="text-end">{{ number_format($invoice->sub_total, 2) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align: left">VAT</th>
                                    <td class="text-end">{{ number_format($invoice->vat_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align: left">NBT</th>
                                    <td class="text-end">{{ number_format($invoice->nbt_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align: left">TAX</th>
                                    <td class="text-end">{{ number_format($invoice->other_tax_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align: left"><strong>Net Total</strong></th>
                                    <td class="text-end"><strong>{{ number_format($invoice->amount, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
                <div style="margin-top: 30px;">
                    Authorized Officer Signature: .......................
                </div>
                <div style="margin-top: 20px; text-align:right;">
                    Printed On {{ Carbon\Carbon::parse(now())->format('Y-m-d h:i A') }}
                </div>
            </div>
        </div>
    </div>
    <script>
        print();
    </script>
</body>

</html>
