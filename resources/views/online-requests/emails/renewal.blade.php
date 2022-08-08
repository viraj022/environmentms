@extends('layouts.email')

@section('content')
    <p>Dear {{ $personName }},</p>
    <p>
        Thank you for your <strong>{{ $requestType }}</strong> request for
        <strong>{{ $businessName }}</strong>.
    </p>
    <p>
        Please click the link below to make a payment of
        <strong>Rs. {{ $paymentAmount }}</strong>.
    </p>
    <div class="payment-info">
        <div><a href="{{ $paymentLink }}" class="payment-link">Click to Pay</a></div>
        <div class="instructions">
            <small>
                Please note that you will be redirected to the online payment gateway
                for payment and no card details will be retained by the
                authority. <strong>This link will expire on 2022-07-26 02:43 PM. You are advised to make the payment before
                    expiry.</strong>
            </small>
        </div>
    </div>
@endsection
