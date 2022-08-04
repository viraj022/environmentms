<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Complete - Environment Authority NWP</title>
    <style>
        #wrapper {
            width: 500px;
            text-align: center;
            margin: 20px auto;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <img src="{{ asset('dist/img/uilogo.png') }}" alt="">
        <h1 style="color: #00ff00;">Payment Completed Successfully!</h1>
        <p>Thank you for your payment of Rs. {{ number_format($paymentRequest->amount, 2) }}. <br />Your payment
            reference
            code
            is : <strong>{{ $paymentRequest->reference_no }}</strong>
        </p>
        <a href="{{ route('payment-request.receipt', $paymentRequest) }}" target="_blank">View Receipt</a>
    </div>
</body>

</html>
