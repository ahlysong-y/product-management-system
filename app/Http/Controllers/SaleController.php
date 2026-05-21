<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\StockHistory;
use App\Models\Product;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::latest()->get();

        return view('sales.index', compact('sales'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = Product::all();

        return view('sales.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Validate sufficient stock
        if ($product->qty < $validated['qty']) {
            return back()->with('error', 'Insufficient stock. Available: ' . $product->qty);
        }

        $total = $product->price * $validated['qty'];

        $sale = Sale::create([
            'product_id' => $product->id,
            'qty' => $validated['qty'],
            'total' => $total
        ]);

        $product->decrement('qty', $validated['qty']);

        StockHistory::create([
            'product_id' => $product->id,
            'type' => 'Stock Out',
            'qty' => $validated['qty']
        ]);

        return redirect('/sales/' . $sale->id)
            ->with('success', 'Sale Completed');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
