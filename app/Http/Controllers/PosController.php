<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\TaxDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Pos/Index', [
            'invoices' => Invoice::orderByDesc('created_at')
            ->with('products.product')
            ->get()
            ->map(function($invoice) {
                $invoice->products->each(function($product) {
                    $product->makeHidden(['created_at', 'updated_at']);
                    $product->product->makeHidden(['user_id', 'category_id', 'purchase_price', 'description', 'image', 'src', 'status', 'created_at', 'updated_at']);
                });
                return $invoice;
            })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return inertia('Pos/Create', [
            'product' => Product::WithoutAppends()->where('barcode', $request->barcode)->get(['id', 'name', 'stock', 'sell_price']),
            'productList' => Product::WithoutAppends()->where('name', 'like', "%$request->name%")->get(['id', 'name', 'stock', 'sell_price']),
            'taxDiscount' => TaxDiscount::find(1)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Add validation
        //$input = $request->except(['vatPercent', 'discountPercent']);
        $input = $request->all();
        $request->validate(['paid' => 'required']);
        $invoiceId = Invoice::createInvoice($input);
        if ($invoiceId) {
            $this->reduceStockQuantityFromProducts($input['products_stock']);
            //Add this to invoice_details table
        $products = $input['products'];
        $products = array_map(function($product) use ($invoiceId) {
            $product['invoice_id'] = $invoiceId;
            $product['created_at'] = now();
            $product['updated_at'] = now();
            return $product;
        }, $products);
        InvoiceDetail::insert($products);
        //return back()->with('success', 'Invoice created!');
        }
        //return back()->with('success', 'Invoice created without product!');
        return back()->with('success', 'Invoice created!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $request->validate(['paid' => 'required']);
        $invoiceId = Invoice::updateInvoice($input, $id);
        if ($invoiceId) {
            $this->reduceStockQuantityFromProducts($input['products_stock']);
            $cases = [];
            $product_ids = [];
            foreach ($input['products'] as $product) {
                $product_id = $product['product_id'];
                $quantity = $product['quantity'];
                $cases[] = "WHEN product_id = {$product_id} AND invoice_id = {$id} THEN {$quantity}";
                $product_ids[] = $product_id;
            }
            $cases = implode(' ', $cases);
            $product_ids = implode(',', $product_ids);
            $sql = "UPDATE invoice_details SET quantity = CASE {$cases} END WHERE product_id IN ({$product_ids}) AND invoice_id = {$id}";
            DB::statement($sql);
        }
        return back()->with('success', 'Invoice Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();
        return back()->with('success', 'Invoice Deleted!');
    }

    /**
     * @param $products_stock
     * @return void
     */
    public function reduceStockQuantityFromProducts($products_stock): void
    {
        $ids = [];
        $cases = [];
        $params = [];
        foreach ($products_stock as $product) {
            $ids[] = $product['id'];
            $cases[] = "WHEN {$product['id']} THEN ?";
            $params[] = $product['stock'];
        }
        $ids = implode(',', $ids);
        $cases = implode(' ', $cases);
        //Use this method instead of foreach direct query beacause performance
        $sql = "UPDATE products SET stock = CASE id {$cases} END WHERE id IN ({$ids})";
        DB::update($sql, $params);
    }
}
