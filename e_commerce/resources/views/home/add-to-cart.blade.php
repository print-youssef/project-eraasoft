@extends('home.layouts.template')
@section('main-content')
    <h2>Add To Cart Page</h2>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="box_main">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Product Name</th>
                            <th>Product Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($cart_items as $item)
                            <tr>
                                @php
                                    $product_name = App\Models\Product::where('id', $item->product_id)->value('product_name');
                                    $product_image = App\Models\Product::where('id', $item->product_id)->value('product_image');
                                @endphp
                                <td>{{ $product_name }}</td>
                                <td><img src="{{ asset($product_image) }}" style="height: 100px"></td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td><a href="{{ route('remove-cart-item', $item->id) }}" class="btn btn-danger">Remove</a>
                                </td>
                            </tr>
                            @php
                                $total = $total + $item->price;
                            @endphp
                        @endforeach
                        <tr>
                            @if ($total > 0)
                                <td>Total</td>
                                <td>${{ $total }}</td>
                                <td>
                                    <a href="{{ route('shipping-address') }}" class="btn btn-primary">Checkout Now</a>
                                </td>
                            @endif
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
