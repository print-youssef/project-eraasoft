@extends('home.layouts.template')
@section('main-content')
    <!-- products section start -->
    <div class="fashion_section">
        <div id="main_slider">
            <div class="container">
                <h1 class="fashion_taital">All Products</h1>
                <div class="fashion_section_2">
                    <div class="row">
                        @foreach ($all_products as $product)
                            <div class="col-lg-4 col-sm-4">
                                <div class="box_main">
                                    <h4 class="shirt_text">{{ $product->product_name }}</h4>
                                    <p class="price_text">Price <span style="color: #262626;">${{ $product->price }}</span>
                                    </p>
                                    <div class="tshirt_img"><img src=" {{ asset($product->product_image) }}">
                                    </div>
                                    <div class="btn_main">
                                        <div class="buy_bt">
                                            <form action="{{ route('add-product-to-cart') }}" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{ $product->id }}" name="product_id">
                                                <input type="hidden" value="{{ $product->price }}" name="price">
                                                <input type="hidden" value="1" name="product_quantity">
                                                <input class="btn btn-warning" type="submit" value="Buy Now">
                                            </form>
                                        </div>
                                        <div class="seemore_bt"><a
                                                href="{{ route('single-product', [$product->id, $product->slug]) }}">See
                                                More</a></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- products section end -->
@endsection
