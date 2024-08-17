<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;
    private static $invoice;

    public static function createInvoice($input)
    {
        self::$invoice = new Invoice();
        return self::extracted($input);
    }
    public static function updateInvoice($input, $id)
    {
        self::$invoice = Invoice::find($id);
        return self::extracted($input);
    }
    public static function extracted($input)
    {
        self::$invoice->subtotal = $input['subtotal'];
        self::$invoice->discount = $input['discount'];
        self::$invoice->discount_percent = $input['discount_percent'];
        self::$invoice->vat = $input['vat'];
        self::$invoice->vat_percent = $input['vat_percent'];
        self::$invoice->total = $input['total'];
        self::$invoice->due = $input['due'];
        self::$invoice->paid = $input['paid'];
        self::$invoice->payment_type = $input['payment_type'];
        self::$invoice->save();
        return self::$invoice->id;
    }

    public function products(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id')->with('product');
    }
}
