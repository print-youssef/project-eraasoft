@extends('home.layouts.template')
@section('main-content')
    <h2>Provide Your Shipping Address Information</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="box_main">
                <form action="{{ route('add-shipping-address') }}" method="POST" class="w-50">
                    @csrf
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number">
                    </div>
                    <div class="form-group">
                        <label for="city_name">City Name</label>
                        <input type="text" class="form-control" name="city_name">
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Postal Code</label>
                        <input type="text" class="form-control" name="postal_code">
                    </div>
                    <input type="submit" value="Next" class="btn btn-primary" style="width: 80px">
                </form>
            </div>
        </div>
    </div>
@endsection
