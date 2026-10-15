<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class AdminSaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('user')->latest()->get();

        return view('admin.sales.index', compact('sales'));
    }

    public function show(Sale $sale)
    {
        return view('admin.sales.show', compact('sale'));
    }
}
