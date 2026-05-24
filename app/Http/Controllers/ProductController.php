<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ?? '';

        $products = Product::where('name', 'LIKE', '%'.$search.'%')
            ->latest()
            ->paginate(5);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'qty' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = null;

        // Upload Image
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')
                ->store('products', 'public');
        }

        $product = Product::create([

            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
            'category_id' => $request->category_id,
            'barcode' => 'PRD-'.rand(100000, 999999),

        ]);

        // Stock History
        StockHistory::create([
            'product_id' => $product->id,
            'type' => 'Stock In',
            'qty' => $request->qty,
        ]);

        // Activity Log
        if (Auth::check()) {

            ActivityLog::create([
                'user_id' => Auth::user()->id,
                'activity' => 'Added product: '.$request->name,
            ]);
        }

        return redirect('/products')
            ->with('success', 'Product Added Successfully');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'qty' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = [

            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ];

        // Upload New Image
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time().'.'.$image->getClientOriginalExtension();

            $image->storeAs('products', $imageName, 'public');

            $data['image'] = 'products/'.$imageName;
        }

        $product->update($data);

        // Activity Log
        if (Auth::check()) {

            ActivityLog::create([
                'user_id' => Auth::user()->id,
                'activity' => 'Updated product: '.$product->name,
            ]);
        }

        return redirect('/products')
            ->with('success', 'Product Updated Successfully');
    }

    public function destroy(Product $product)
    {
        // Activity Log
        if (Auth::check()) {

            ActivityLog::create([
                'user_id' => Auth::user()->id,
                'activity' => 'Deleted product: '.$product->name,
            ]);
        }

        $product->delete();

        return redirect('/products')
            ->with('success', 'Product Deleted Successfully');
    }
}
