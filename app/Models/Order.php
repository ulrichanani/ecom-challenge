<?php

namespace App\Models;

use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class Order extends Model
{
    use FormAccessible;

    const STATUSES = [
        'not_shipped' => 1,
        'shipped' => 2,
        'cancelled' => 3,
    ];

    const STATUSES_LABELS = [
        1 => 'Not Shipped',
        2 => 'Shipped',
        3 => 'Cancelled',
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

    protected $casts = [
        'created_on' => 'datetime',
        'shipped_on' => 'datetime'
    ];

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
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id', 'shipping_id');
    }

    public function shippingRegion()
    {
        return $this->shipping()->with('shippingRegion');
    }

    /*
     * HELPERS
     */
    public function getIdAttribute()
    {
        return $this->order_id;
    }

    public function getStatusLabelAttribute()
    {
        return self::STATUSES_LABELS[$this->status] ?? '';
    }

    public function formShippedOnAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : '';
    }
}
