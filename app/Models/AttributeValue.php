<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    /*
     * ELOQUENT CONFIG
     */
    public $timestamps = false;

    protected $fillable = [
        'attribute_value_id', 'attribute_id', 'value'
    ];

    protected $table = 'attribute_value';

    public function getKeyName()
    {
        return 'attribute_value_id';
    }

    /*
     * RELATIONS
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    /*
     * ACCESSORS
     */
    public function getIdAttribute()
    {
        return $this->attribute_value_id;
    }
}
