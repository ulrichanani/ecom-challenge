<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function attributeValues()
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
     * ELOQUENT METHODS OVERRIDE
     */
    public function delete()
    {
        $result = \DB::raw("call catalog_delete_product($this->id)");
        return is_null(object_get($result[0], '-1'));
    }

    /*
     * HELPERS
     */
    public function getAttributesValuesIds()
    {
        return $this->attributeValues()->pluck('product_attribute.attribute_value_id');
    }

    public function getCategoriesIds()
    {
        return $this->categories()->pluck('attribute_value_id');
    }

    public function getAttributesNamesAndValues() {
        $attr = collect(DB::select('call catalog_get_product_attributes(1)'));
        $attr = $attr->transform(function ($item, $key) {
            $item->fullname = $item->attribute_name . ' : ' . $item->attribute_value;
            return $item;
        })->pluck('fullname', 'attribute_value_id');
        return $attr;
    }
}
