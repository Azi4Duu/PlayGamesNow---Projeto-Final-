<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class AdminSaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with('user');

        if($request->filled('search')){
            $query->where(function ($q) use ($request) {
                $q->where('id', $request->search)->orWhereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            });
        }

        if($request->filled('status')){
            $query->where('status', $request->status);
        }

        if($request->filled('payment_method')){
            $query->where('payment_method', $request->payment_method);
        }

        $sales = $query->latest()->paginate(6)->withQueryString();

        return view('admin.sales.index', compact('sales'));
    }

    public function show(Sale $sale)
    {
        return view('admin.sales.show', compact('sale'));
    }
}
