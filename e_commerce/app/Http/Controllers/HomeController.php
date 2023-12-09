<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $all_products = Product::latest()->get();
        return view('home.home', compact('all_products'));
    }
}
