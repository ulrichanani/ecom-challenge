<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class Order extends Model
{
    const STATUSES = [
        'not_shipped' => 1,
        'shipped' => 2,
        'cancelled' => 2,
    ];

    /*
     * ELOQUENT CONFIG
     */
    public $timestamps = false;

    protected $fillable = [
        'order_id', 'total_amount', 'created_on', 'shipped_on', 'status',
        'comments', 'customer_id', 'auth_code', 'reference', 'shipping_id', 'tax_id'
    ];

    protected $table = 'orders';

    public function getKeyName()
    {
        return 'order_id';
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->created_on = $model->freshTimestamp();
        });
    }

    /*
     * RELATIONS
     */
    public function items()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /*
     * HELPERS
     */
    public function getIdAttribute()
    {
        return $this->order_id;
    }
}
