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
