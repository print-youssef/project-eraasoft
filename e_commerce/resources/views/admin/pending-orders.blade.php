@extends('admin.layouts.template')
@section('page_title')
    Pending Orders - Mobile Store
@endsection
@section('content')
    <div class="container my-5">
        <div class="card p-3">
            <h2 class="text-center">Pending Orders</h2>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>User Id</th>
                        <th>Shipping Information</th>
                        <th>Product Id</th>
                        <th>Quantity</th>
                        <th>Customer Will Pay</th>
                    </tr>
                    @foreach ($pending_orders as $order)
                        <tr>
                            <td>{{ $order->user_id }}</td>
                            <td>
                                <ul>
                                    <li>Phone Number - {{ $order->shipping_phone_number }}</li>
                                    <li>City - {{ $order->shipping_city }}</li>
                                    <li>Postal Code - {{ $order->shipping_postal_code }}</li>
                                </ul>
                            </td>
                            <td>{{ $order->product_id }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>${{ $order->total_price }}</td>
                        </tr>
                    @endforeach
                </table>
                {{ $pending_orders->links() }}
            </div>
        </div>
    </div>
@endsection
