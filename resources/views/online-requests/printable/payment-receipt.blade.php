<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Receipt</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .receipt-content .invoice-wrapper {
            background: #FFF;
            border: 1px solid #CDD3E2;
            box-shadow: 0px 0px 1px #CCC;
            padding: 40px;
            margin-top: 40px;
            border-radius: 4px;
        }

        @media (min-width: 1200px) {
            .receipt-content .container {
                width: 900px;
            }
        }

        @media print {
            @page {
                size: A4;
                orientation: portrait;
                margin: .25in;
            }

            body {
                background-color: #fff;
            }

            .receipt-content .container {
                width: 100%;
            }

            .receipt-content .invoice-wrapper {
                border: none;
                padding: 0px;
            }
        }

        .receipt-content .logo {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <div class="receipt-content">
        <div class="container bootstrap snippets bootdey">
            <div class="row">
                <div class="col-md-12">
                    <div class="invoice-wrapper">
                        <p>
                            <small>Generated at: {{ date('Y-m-d h:i A') }}</small>
                        </p>
                        <div class="row">
                            <div class="col-lg-12 text-center mb-5">
                                <div class="image">
                                    <img src="{{ asset('dist/img/uilogo.png') }}" alt="" height="100">
                                </div>
                                <p>
                                    Provincial Environmental Authority of North Western Province <br>
                                    Dambulla road, Kurunegala. <br>
                                    Tel: 037-22-25-236 |
                                    Fax: 037-22-29-688 |
                                    Email: pentanwp@gmail.com
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h1>Payment Receipt</h1>
                            </div>
                            <div class="col-lg-8 text-left">
                                <p>
                                    {{-- Reference No. : <strong>{{ $paymentRequest->reference_no }}</strong> <br> --}}
                                    Invoice Number: <strong>{{ $invoice->invoice_number }}</strong> <br>
                                    Date: <strong>{{ $paymentRequest->created_at->format('Y-m-d') }}</strong>
                                </p>
                            </div>
                            <div class="col-lg-4 text-right">
                                <p>
                                    <strong>{{ $personName }} </strong><br>
                                    <strong>{{ $businessName }}</strong> <br>
                                    <strong>{{ $client->industry_address }}</strong> <br>
                                    <strong>{{ $client->contact_no }}</strong>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-striped table-bordered">
                                    <colgroup>
                                        <col style="width: 80%;">
                                        <col style="width: 20%;">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th class="text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                {{ Str::ucfirst($requestType) }} Request for {{ $businessName }}
                                            </td>
                                            <td class="text-right">{{ number_format($paymentRequest->amount, 2) }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <td class="text-right">{{ number_format($paymentRequest->amount, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <p>
                                    <small>This is a system generated receipt. No signature is necessary.</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
