<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /*
     * ELOQUENT CONFIG
     */
    public $timestamps = false;

    protected $fillable = [
        'review_id', 'customer_id', 'product_id', 'rating', 'review', 'created_on'
    ];

    protected $table = 'review';

    public function getKeyName()
    {
        return 'review_id';
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
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
