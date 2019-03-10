<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRegion extends Model
{
    /*
     * ELOQUENT CONFIG
     */
    public $timestamps = false;

    protected $fillable = [
        'shipping_region'
    ];

    protected $table = 'shipping_region';

    public function getKeyName()
    {
        return 'shipping_region_id';
    }

    /*
     * HELPERS
     */
    public function getIdAttribute()
    {
        return $this->shipping_region_id;
    }

    public static function getAllIdsAndNames()
    {
        return self::pluck('shipping_region', 'shipping_region_id');
    }
}
