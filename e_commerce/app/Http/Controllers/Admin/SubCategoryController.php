<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::latest()->paginate(5);
        return view('admin.all-subcategories', compact('subcategories'));
    }

    public function addSubCategory()
    {
        $categories = Category::latest()->get();
        return view('admin.add-subcategory', compact('categories'));
    }

    public function storeSubCategory(Request $request)
    {
        $request->validate([
            'subcategory_name' => 'required|alpha',
            'category_id' => 'required'
        ]);
        $category_id = $request->category_id;
        $category_name = Category::where('id', $category_id)->value('category_name');
        Subcategory::insert([
            'subcategory_name' => $request->subcategory_name,
            'slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
            'category_id' => $category_id,
            'category_name' => $category_name
        ]);
        Category::where('id', $category_id)->increment('subcategory_count', 1);
        return redirect()->route('all-subcategories')->with('message', 'Sub Category Added Successfully!');
    }
    public function editSubCategory($id)
    {
        $subcategory_info = Subcategory::findOrFail($id);
        return view('admin.edit-subcategory', compact('subcategory_info'));
    }

    public function updateSubCategory(Request $request)
    {
        $subcategory_id = $request->subcategory_id;
        $request->validate([
            'subcategory_name' => 'required|unique:subcategories|alpha',
        ]);
        Subcategory::findOrFail($subcategory_id)->update([
            'subcategory_name' => $request->subcategory_name,
            'slug' => strtolower(str_replace(' ', '-', $request->subcategory_name))
        ]);
        $affectedProducts = Product::where('product_subcategory_id', $subcategory_id)->get();
        foreach ($affectedProducts as $product) {
            $product->update([
                'product_subcategory_name' => $request->subcategory_name,
                'slug' => strtolower(str_replace(' ', '-', $request->category_name))
            ]);
        }
        return redirect()->route('all-subcategories')->with('message', 'Sub Category Updated Successfully!');
    }

    public function deleteSubCategory($id)
    {
        $category_id = Subcategory::where('id', $id)->value('category_id');
        Subcategory::findOrFail($id)->delete();
        Category::where('id', $category_id)->decrement('subcategory_count', 1);
        return redirect()->route('all-subcategories')->with('message', 'Sub Category Deleted Successfully!');
    }
}
