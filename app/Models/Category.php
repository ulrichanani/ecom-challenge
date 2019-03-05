<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /*
     * ELOQUENT CONFIG
     */
    public $timestamps = false;

    protected $fillable = [
        'category_id', 'department_id', 'name', 'description',
    ];

    protected $table = 'category';

    public function getKeyName()
    {
        return 'category_id';
    }

    /*
     * RELATIONS
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category',
            'category_id', 'product_id');
    }

    /*
     * ACCESSORS
     */
    public function getIdAttribute()
    {
        return $this->category_id;
    }

    /*
     * ELOQUENT METHODS OVERRIDE
     */
    public function delete()
    {
        $result  = \DB::select("call catalog_delete_category($this->id)");
        return is_null(object_get($result[0], '-1'));
    }

    /*
     * HELPERS
     */
    public static function getNamesAndIds()
    {
        return Category::pluck('name', 'category_id');
    }
}
