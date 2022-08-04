@extends('layouts.email')

@section('content')
    <h1>Payment Acknowledgement</h1>
    <p>Dear {{ $personName }},</p>
    <p>
        Thank you for your payment of <strong>Rs. {{ $paymentAmount }}</strong> for <strong>{{ $requestType }}</strong>
        request of
        <strong>{{ $businessName }}</strong>.
    </p>
    <p>
        <small>Reference No.: {{ $referenceNo }}</small>
    </p>
    <p>
        <small>
            This is a system generated receipt email. No signature is necessary,
        </small>
    </p>
@endsection
