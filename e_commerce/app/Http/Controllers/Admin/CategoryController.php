<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(5);
        return view('admin.all-categories', compact('categories'));
    }

    public function addCategory()
    {
        return view('admin.add-category');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories|alpha',
        ]);
        Category::insert([
            'category_name' => $request->category_name,
            'slug' => strtolower(str_replace(' ', '-', $request->category_name))
        ]);
        return redirect()->route('all-categories')->with('message', 'Category Added Successfully!');
    }

    public function editCategory($id)
    {
        $category_info = Category::findOrFail($id);
        return view('admin.edit-category', compact('category_info'));
    }

    public function updateCategory(Request $request)
    {
        $category_id = $request->category_id;
        $request->validate([
            'category_name' => 'required|alpha',
        ]);
        Category::findOrFail($category_id)->update([
            'category_name' => $request->category_name,
            'slug' => strtolower(str_replace(' ', '-', $request->category_name))
        ]);
        $affectedSubcategories = Subcategory::where('category_id', $category_id)->get();
        foreach ($affectedSubcategories as $subcategory) {
            $subcategory->update([
                'category_name' => $request->category_name,
                'slug' => strtolower(str_replace(' ', '-', $request->category_name))
            ]);
        }
        $affectedProducts = Product::where('product_category_id', $category_id)->get();
        foreach ($affectedProducts as $product) {
            $product->update([
                'product_category_name' => $request->category_name,
                'slug' => strtolower(str_replace(' ', '-', $request->category_name))
            ]);
        }
        return redirect()->route('all-categories')->with('message', 'Category Updated Successfully!');
    }

    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('all-categories')->with('message', 'Category Deleted Successfully!');
    }
}
