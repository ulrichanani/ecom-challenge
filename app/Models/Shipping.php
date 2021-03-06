<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    /*
     * ELOQUENT CONFIG
     */
    public $timestamps = false;

    protected $fillable = [
        'shipping_type','shipping_cost','shipping_region_id'
    ];

    protected $table = 'shipping';

    public function getKeyName()
    {
        return 'shipping_id';
    }

    /*
     * RELATIONS
     */
    public function shippingRegion()
    {
        $this->belongsTo(ShippingRegion::class, 'shipping_region_id', 'shipping_region_id');
    }

    /*
     * HELPERS
     */
    public function getIdAttribute()
    {
        return $this->shipping_id;
    }
}
