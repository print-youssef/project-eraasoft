@extends('home.layouts.userprofiletemplate')
@section('profile-content')
    <h2>Order Details</h2>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <table class="table">
        <tr>
            <td>Product Id</td>
            <td>Price</td>
        </tr>
        @foreach ($pending_orders as $order)
            <tr>
                <td>{{ $order->product_id }}</td>
                <td>${{ $order->total_price }}</td>
            </tr>
        @endforeach
    </table>
@endsection
