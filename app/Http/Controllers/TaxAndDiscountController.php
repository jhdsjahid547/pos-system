<?php

namespace App\Http\Controllers;

use App\Models\TaxDiscount;
use Illuminate\Http\Request;

class TaxAndDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('TaxDiscount/Index', ['taxDiscounts' => TaxDiscount::orderByDesc('created_at')->get(['id', 'vat', 'discount'])]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vat' => 'required|numeric|min:5|max:50',
            'discount' => 'required|numeric|min:5|max:80'
        ]);
        TaxDiscount::createTaxDiscount($request);
        return back()->with('success', 'Tax and Discount Created!');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'vat' => 'required|numeric|min:5|max:50',
            'discount' => 'required|numeric|min:5|max:80'
        ]);
        TaxDiscount::updateTaxDiscount($request, $id);
        return back()->with('success', 'Options Updated!');
    }
}
