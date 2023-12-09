@extends('home.layouts.template')
@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="box_main">
                    <div class="tshirt_img"><img src="{{ asset($product->product_image) }}"></div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="box_main">
                    <div class="product-info">
                        <h4 class="shirt_text text-left">{{ $product->product_name }}</h4>
                        <p class="price_text text-left">Price <span style="color: #262626;">${{ $product->price }}</span>
                        </p>
                    </div>
                    <div class="my-3 product-details">
                        <p class="lead">{{ $product->product_short_description }}</p>
                        <ul class="p-2 bg-light my-2">
                            <li>Category - {{ $product->product_category_name }}</li>
                            <li>Sub Category - {{ $product->product_subcategory_name }}</li>
                            <li>Available Quantity - {{ $product->quantity }}</li>
                        </ul>
                    </div>
                    <div class="btn_main">
                        <form action="{{ route('add-product-to-cart') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $product->id }}" name="product_id">
                            <div class="form-group">
                                <input type="hidden" value="{{ $product->price }}" name="price">
                                <label for="product_quantity">How Many Pieces?</label>
                                <input class="form-control w-25" type="number" min="1" placeholder="1"
                                    name="product_quantity">
                            </div>
                            <input class="btn btn-warning mb-2" type="submit" value="Add To Cart">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- fashion section start -->
        <div class="fashion_section">
            <div id="main_slider">
                <div class="container">
                    <h1 class="fashion_taital">All Products</h1>
                    <div class="fashion_section_2">
                        <div class="row">
                            @foreach ($related_products as $product)
                                <div class="col-lg-4 col-sm-4">
                                    <div class="box_main">
                                        <h4 class="shirt_text">{{ $product->product_name }}</h4>
                                        <p class="price_text">Price <span
                                                style="color: #262626;">${{ $product->price }}</span>
                                        </p>
                                        <div class="tshirt_img"><img src=" {{ asset($product->product_image) }}">
                                        </div>
                                        <div class="btn_main">
                                            <div class="buy_bt">
                                                <form action="{{ route('add-product-to-cart') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" value="{{ $product->id }}" name="product_id">
                                                    <input class="btn btn-warning" type="submit" value="Buy Now">
                                                </form>
                                            </div>
                                            <div class="seemore_bt">
                                                <a href="{{ route('single-product', [$product->id, $product->slug]) }}">See
                                                    More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- fashion section end -->
    </div>
@endsection
