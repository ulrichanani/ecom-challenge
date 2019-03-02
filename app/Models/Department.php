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
        // return $this->hasMany(Category::class);
    }
}
