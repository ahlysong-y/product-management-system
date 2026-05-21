<?php

namespace App\Http\Controllers;

use App\Models\StockHistory;

class StockHistoryController extends Controller
{
    public function index()
    {
        $histories = StockHistory::latest()->get();

        return view('stocks.index', compact('histories'));
    }
}
