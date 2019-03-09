<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /*
     * ELOQUENT CONFIG
     */
    public $timestamps = false;

    protected $fillable = [
        'department_id', 'name', 'description',
    ];

    protected $table = 'department';

    public function getKeyName()
    {
        return 'department_id';
    }

    /*
     * RELATIONS
     */
    public function categories()
    {
        return $this->hasMany(Category::class, 'department_id');
    }

    public function products()
    {
        return Product::join('product_category', 'product_category.product_id', 'product.product_id')
            ->whereIn('product_category.category_id', $this->categories->pluck('category_id'));
        return $this->categories()->with('products');
        return $this->hasManyThrough(Product::class, Category::class, 'department_id', 'category_id');
    }

    /*
     * ACCESSORS
     */
    public function getIdAttribute()
    {
        return $this->department_id;
    }

    /*
     * ELOQUENT METHODS OVERRIDE
     */
    public function delete()
    {
        $result  = \DB::select("call catalog_delete_department($this->id)");
        return is_null(object_get($result[0], '-1'));
    }
}
