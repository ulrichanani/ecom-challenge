<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class OrderDetail extends Model
{
    /*
     * ELOQUENT CONFIG
     */
    public $timestamps = false;

    protected $fillable = [
        'item_id', 'order_id', 'product_id', 'attributes', 'product_name', 'quantity',
        'unit_cost'
    ];

    protected $table = 'order_detail';

    public function getKeyName()
    {
        return 'item_id';
    }

    /*
     * RELATIONS
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /*
     * HELPERS
     */
    public function getIdAttribute()
    {
        return $this->item_id;
    }

    public function getSubTotalAttribute()
    {
        return $this->product->realPrice * $this->quantity;
    }
}
