<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /*
     * CONSTANTS
     */
    const DISPLAY_OPTIONS = [
        '0' => 'Hide',
        '1' => 'Show'
    ];

    /*
     * ELOQUENT CONFIG
     */
    public $timestamps = false;

    protected $fillable = [
        'product_id', 'name', 'description', 'price', 'discounted_price', 'image', 'image_2',
        'thumbnail', 'display'
    ];

    protected $table = 'product';

    public function getKeyName()
    {
        return 'product_id';
    }

    /*
     * RELATIONS
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category',
            'product_id', 'category_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute',
            'product_id', 'attribute_value_id');
    }

    /*
     * ACCESSORS
     */
    public function getIdAttribute()
    {
        return $this->product_id;
    }

    /*
     * HELPERS
     */
    public function getAttributesValuesIds()
    {
        return $this->attributes()->pluck('attribute_value_id');
    }

    public function getCategoriesIds()
    {
        return $this->categories()->pluck('attribute_value_id');
    }
}
