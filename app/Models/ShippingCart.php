<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCart extends Model
{
    protected $fillable = [
        'cart_id', 'product_id', 'attributes', 'quantity', 'buy_now', 'added_on'
    ];

    public function cart()
    {
        // $this->belongsTo('App\Cart');
    }

    public function product()
    {
        $this->belongsToMany(Product::class);
    }

    public function subTotal($nb)
    {
        return $this->realPrice * abs($nb);
    }
}
