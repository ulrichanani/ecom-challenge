<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = ['shipping_type','shipping_cost','shipping_region_id'];

    public function shippingRegion() {
        $this->belongsTo(ShippingRegion::class);
    }
}
