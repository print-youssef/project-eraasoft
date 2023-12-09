<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function categoryPage($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('product_category_id', $id)->latest()->get();
        return view('home.category', compact('category', 'products'));
    }

    public function singleProduct($id)
    {
        $product = Product::findOrFail($id);
        $subcategory_id = Product::where('id', $id)->value('product_subcategory_id');
        $related_products = Product::where('product_subcategory_id', $subcategory_id)->latest()->get();
        return view('home.product', compact('product', 'related_products'));
    }

    public function addToCart()
    {
        $user_id = Auth::id();
        $cart_items = Cart::where('user_id', $user_id)->get();
        return view('home.add-to-cart', compact('cart_items'));
    }

    public function removeCartItem($id)
    {
        Cart::findOrFail($id)->delete();
        return redirect()->route('add-to-cart')->with('message', 'Your Item Has Been Deleted from cart successfully!');
    }

    public function getShippingAddress()
    {
        return view('home.shipping-address');
    }

    public function addShippingAddress(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'city_name' => 'required',
            'postal_code' => 'required'
        ]);
        ShippingInfo::insert([
            'user_id' => Auth::id(),
            'phone_number' => $request->phone_number,
            'city_name' => $request->city_name,
            'postal_code' => $request->postal_code
        ]);
        return redirect()->route('checkout');
    }

    public function addProductToCart(Request $request)
    {
        $product_price = $request->price;
        $quantity = $request->product_quantity;
        $price = $product_price * $quantity;
        $request->validate([
            'product_quantity' => 'required',
        ]);
        Cart::insert([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'quantity' => $request->product_quantity,
            'price' => $price
        ]);
        return redirect()->route('add-to-cart')->with('message', 'Your Item Has Been Added to cart successfully!');
    }

    public function checkOut()
    {
        $user_id = Auth::id();
        $cart_items = Cart::where('user_id', $user_id)->get();
        $shipping_address = ShippingInfo::where('user_id', $user_id)->first();
        return view('home.checkout', compact('cart_items', 'shipping_address'));
    }

    public function placeOrder()
    {
        $user_id = Auth::id();
        $cart_items = Cart::where('user_id', $user_id)->get();
        $shipping_address = ShippingInfo::where('user_id', $user_id)->first();
        foreach ($cart_items as $item) {
            Order::insert([
                'user_id' => $user_id,
                'shipping_phone_number' => $shipping_address->phone_number,
                'shipping_city' => $shipping_address->city_name,
                'shipping_postal_code' => $shipping_address->postal_code,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'total_price' => $item->price
            ]);
            $id = $item->id;
            Cart::findOrFail($id)->delete();
        }
        ShippingInfo::where('user_id', $user_id)->first()->delete();
        return redirect()->route('user-pending-orders')->with('message', 'Your Order Has Been Placed successfully!');
    }

    public function pendingOrders()
    {
        $pending_orders = Order::where('status', 'pending')->latest()->get();
        return view('home.pending-orders', compact('pending_orders'));
    }
}
