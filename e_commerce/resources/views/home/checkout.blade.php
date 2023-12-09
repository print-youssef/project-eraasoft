@extends('home.layouts.template')
@section('main-content')
    <h1>Final Step To Place Your Order</h1>
    <div class="row">
        <div class="col-8">
            <div class="box_main">
                <h2>Product Will Be Sent With In 3 Days To</h2>
                <hr>
                <p>- City -> {{ $shipping_address->city_name }}</p>
                <p>- Postal Code -> {{ $shipping_address->postal_code }}</p>
                <p>- Phone Number -> {{ $shipping_address->phone_number }}</p>
                <hr>
                <div class="form-group d-flex">
                    <form action="{{ route('place-order') }}" method="POST">
                        @csrf
                        <input type="submit" value="Okey Place Order" class="btn btn-primary mr-3">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="box_main">
                <h3>Your Final Products Are -</h3>
                <div class="table-responsive mt-2">
                    <table class="table">
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($cart_items as $item)
                            <tr>
                                @php
                                    $product_name = App\Models\Product::where('id', $item->product_id)->value('product_name');
                                @endphp
                                <td>{{ $product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->price }}</td>
                            </tr>
                            @php
                                $total = $total + $item->price;
                            @endphp
                        @endforeach
                        <tr>
                            <td></td>
                            <td>Total</td>
                            <td>${{ $total }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
