@extends('home.layouts.template')
@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="box_main">
                    @yield('profile-content')
                </div>
            </div>
        </div>
    </div>
@endsection
