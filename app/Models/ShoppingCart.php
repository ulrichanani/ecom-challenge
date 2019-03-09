<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class ShoppingCart extends Model
{
    /*
     * ELOQUENT CONFIG
     */
    public $timestamps = false;

    protected $fillable = [
        'item_id', 'cart_id', 'product_id', 'attributes', 'quantity', 'buy_on', 'added_on'
    ];

    protected $table = 'shopping_cart';

    public function getKeyName()
    {
        return 'item_id';
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->added_on = $model->freshTimestamp();
        });
    }

    /*
     * RELATIONS
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /*
     * SCOPES
     */
    public function scopeCurrent($query)
    {
        return $query->where('cart_id', self::getCartId());
    }

    public function scopeBuyNow($query)
    {
        return $query->where('buy_now', true);
    }

    public function scopeSaved($query)
    {
        return $query->where('buy_now', false);
    }

    /*
     * HELPERS
     */
    public function getIdAttribute()
    {
        return $this->item_id;
    }

    public static function getCartId()
    {
        $cartId = null;
        if(Cookie::has('cart_id')) {
            $cartId = ShoppingCart::where('cart_id', Cookie::get('cart_id'))->value('cart_id');
            // dump('Old', $cartId);
        }

        if(empty($cartId)) {
            $cartId = Carbon::now()->getTimestamp() . auth()->id();
            Cookie::queue('cart_id', $cartId, 1000000);
           // dump('New', $cartId);
        }

        return $cartId;
    }

    public static function getCartItems() {
        return ShoppingCart::current()->buyNow()->get();
    }

    public function getSubTotalAttribute()
    {
        return $this->product->realPrice * $this->quantity;
    }
}
