<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return view('admin.all-products', compact('products'));
    }

    public function addProduct()
    {
        $categories = Category::latest()->get();
        $subcategories = Subcategory::latest()->get();
        return view('admin.add-product', compact('categories', 'subcategories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required|unique:products|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'product_short_description' => 'required|string',
            'product_long_description' => 'required|string',
            'product_category_id' => 'required',
            'product_subcategory_id' => 'required',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $image = $request->file('product_image');
        $image_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $request->product_image->move(public_path('upload'), $image_name);
        $image_url = 'upload/' . $image_name;
        $category_id = $request->product_category_id;
        $subcategory_id = $request->product_subcategory_id;
        $category_name = Category::where('id', $category_id)->value('category_name');
        $subcategory_name = Subcategory::where('id', $subcategory_id)->value('subcategory_name');
        Product::insert([
            'product_name' => $request->product_name,
            'product_short_description' => $request->product_short_description,
            'product_long_description' => $request->product_long_description,
            'price' => $request->price,
            'product_category_name' => $category_name,
            'product_subcategory_name' => $subcategory_name,
            'product_category_id' => $request->product_category_id,
            'product_subcategory_id' => $request->product_subcategory_id,
            'product_image' => $image_url,
            'quantity' => $request->quantity,
            'slug' => strtolower(str_replace(' ', '-', $request->product_name))
        ]);
        Category::where('id', $category_id)->increment('product_count', 1);
        Subcategory::where('id', $subcategory_id)->increment('product_count', 1);
        return redirect()->route('all-products')->with('message', 'Product Added Successfully!');
    }

    public function editProductImage($id)
    {
        $product_info = Product::findOrFail($id);
        return view('admin.edit-product-image', compact('product_info'));
    }

    public function updateProductImage(Request $request)
    {
        $request->validate([
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $image_id = $request->image_id;
        $image = $request->file('product_image');
        $image_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $request->product_image->move(public_path('upload'), $image_name);
        $image_url = 'upload/' . $image_name;
        Product::findOrFail($image_id)->update([
            'product_image' => $image_url
        ]);
        return redirect()->route('all-products')->with('message', 'Product Image Updated Successfully!');
    }

    public function editProduct($id)
    {
        $product_info = Product::findOrFail($id);
        return view('admin.edit-product', compact('product_info'));
    }

    public function updateProduct(Request $request)
    {
        $product_id = $request->product_id;
        $request->validate([
            'product_name' => 'string',
            'price' => 'numeric',
            'quantity' => 'numeric',
            'product_short_description' => 'string',
            'product_long_description' => 'string'
        ]);
        Product::findOrFail($product_id)->update([
            'product_name' => $request->product_name,
            'product_short_description' => $request->product_short_description,
            'product_long_description' => $request->product_long_description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'slug' => strtolower(str_replace(' ', '-', $request->product_name))
        ]);
        return redirect()->route('all-products')->with('message', 'Product Information Updated Successfully!');
    }

    public function deleteProduct($id)
    {
        $category_id = Product::where('id', $id)->value('product_category_id');
        $subcategory_id = Product::where('id', $id)->value('product_subcategory_id');
        Product::findOrFail($id)->delete();
        Category::where('id', $category_id)->decrement('product_count', 1);
        Subcategory::where('id', $subcategory_id)->decrement('product_count', 1);
        return redirect()->route('all-products')->with('message', 'Product Deleted Successfully!');
    }
}
