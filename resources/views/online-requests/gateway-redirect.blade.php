<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Redirecting...</title>
    <script src="https://test-bankofceylon.mtf.gateway.mastercard.com/checkout/version/60/checkout.js"
        data-error="errorCallback" data-cancel="cancelCallback"></script>
    <script>
        function errorCallback(error) {
            alert('Payment error.');
            console.log(JSON.stringify(error));
        }

        function cancelCallback() {
            alert('Payment cancelled.');
            console.log('Payment cancelled');
        }

        Checkout.configure({
            merchant: '{{ config('ipg.merchant_id') }}',
            order: {
                id: "{{ $orderId }}",
                itemAmount: {{ $paymentRequest->amount }},
                description: 'Payment for Environment Authority NWP',
            },
            session: {
                id: "{{ $initParams['session_id'] }}"
            },
            interaction: {
                merchant: {
                    name: 'Environment Authority NWP',
                    address: {
                        line1: 'Dambulla road,',
                        line2: 'Kurunegala, 60000.'
                    }
                }
            }
        });
        Checkout.showPaymentPage();
    </script>
    <style>
        #wrapper {
            width: 500px;
            text-align: center;
            margin: 20px auto;
        }

        .alert.alert-danger {
            background-color: #f7bcbc;
            border: 2px solid #ffa5a5;
            padding: 10px 15px;
            border-radius: 15px;
            font-family: Helvetica, Arial, Verdana, Tahoma, serif;
            color: #a32a2a;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <img src="{{ asset('dist/img/uilogo.png') }}" alt="">
        <p>Please wait while you are redirected...</p>
        <div>
            <noscript>
                <div class="alert alert-danger">
                    You need to enable Javascript in your web browser to proceed with the payment. Please enable it and
                    click the link in the email to try again.
                </div>
            </noscript>
        </div>
    </div>
</body>

</html>
