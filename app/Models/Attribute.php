<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    /*
     * ELOQUENT CONFIG
     */
    public $timestamps = false;

    protected $fillable = [
        'attribute_id', 'name'
    ];

    protected $table = 'attribute';

    public function getKeyName()
    {
        return 'attribute_id';
    }

    /*
     * RELATIONS
     */
    public function values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id');
    }

    /*
     * ACCESSORS
     */
    public function getIdAttribute()
    {
        return $this->attribute_id;
    }
}
