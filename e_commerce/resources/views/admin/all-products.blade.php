@extends('admin.layouts.template')
@section('page_title')
    All Products - Mobile Store
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pages/</span> All Products</h4>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="card">
            <h5 class="card-header">All Available Products Information</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>
                                    <img style="height: 100px" src="{{ asset($product->product_image) }}" alt="">
                                    <hr>
                                    <a href="{{ route('edit-product-image', $product->id) }}" class="btn btn-primary">Update
                                        Image</a>
                                </td>
                                <td>${{ $product->price }}</td>
                                <td>
                                    <a href="{{ route('edit-product', $product->id) }}" class="btn btn-primary">Edit</a>
                                    <a href="{{ route('delete-product', $product->id) }}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
