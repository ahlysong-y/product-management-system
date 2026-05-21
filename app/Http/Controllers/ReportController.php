<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function pdf()
    {
        $products = Product::all();
        $inventoryTotal = $products->sum(fn($p) => $p->qty * $p->price);

        $pdf = Pdf::loadView('reports.products', compact('products', 'inventoryTotal'));

        return $pdf->download('products-report.pdf');
    }

    public function print()
    {
        $products = Product::all();
        $inventoryTotal = $products->sum(fn($p) => $p->qty * $p->price);

        return view('reports.print', compact('products', 'inventoryTotal'));
    }

    public function excel()
    {
        return Excel::download(
            new ProductsExport,
            'products.xlsx'
        );
    }
}
