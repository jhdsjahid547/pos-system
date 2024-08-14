<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxDiscount extends Model
{
    use HasFactory;
    private static $taxDiscount;

    private static function extracted($request)
    {
        self::$taxDiscount->vat = $request->vat;
        self::$taxDiscount->discount = $request->discount;
        self::$taxDiscount->save();
    }
    public static function createTaxDiscount($request)
    {
        self::$taxDiscount = new TaxDiscount();
        self::extracted($request);

    }
    public static function updateTaxDiscount($request,$id)
    {
        self::$taxDiscount = TaxDiscount::find($id);
        self::extracted($request);
    }
}
