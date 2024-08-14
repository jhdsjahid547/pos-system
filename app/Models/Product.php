<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['src'];
    private static $product, $withoutAppends = false;

    public static function imagePath($request) {
        $file = $request->file('image');
        $path = $file->store('images', 'public');
        return $path;
    }
    public static function extracted($request) {
        self::$product->category_id = $request->category_id;
        self::$product->barcode = $request->barcode;
        self::$product->name = $request->name;
        if ($request->has('description')) {
            self::$product->description = $request->description;
        }
        if ($request->has('stock')) {
            self::$product->stock = $request->stock;
        }
        if ($request->has('purchase_price')) {
            self::$product->purchase_price = $request->purchase_price;
        }
        self::$product->sell_price = $request->sell_price;
    }
    public static function createProduct($request)
    {
        self::$product = new Product();
        self::$product->user_id = Auth::id();
        self::extracted($request);
        if ($request->hasFile('image')) {
            self::$product->image = self::imagePath($request);
        }
        self::$product->save();
    }
    public static function updateProduct($request, $id) {
        self::$product = Product::find($id);
        self::extracted($request);
        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists(self::$product->image)) {
                Storage::disk('public')->delete(self::$product->image);
            }
            self::$product->image = self::imagePath($request);
        }
        self::$product->save();
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getSrcAttribute()
    {
        return asset("storage/{$this->image}");
    }
    public function scopeWithoutAppends($query)
    {
        self::$withoutAppends = true;
        return $query;
    }
    protected function getArrayableAppends()
    {
        if (self::$withoutAppends) {
            return [];
        }
        return parent::getArrayableAppends();
    }
}
