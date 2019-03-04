<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    /*
     * HELPERS
     */
    public static function getAllWithValues()
    {
        return AttributeValue::leftJoin('attribute',
            'attribute_value.attribute_id', '=', 'attribute.attribute_id')
            ->select(
                'attribute.attribute_id as attribute_id',
                'attribute_value.attribute_value_id as attribute_value_id',
                'attribute_value.attribute_value_id as id',
                'attribute_value.value as value',
                'attribute.name as name',
                DB::raw("CONCAT(attribute.name, ' : ', attribute_value.value) as fullname")
            )
            ->whereNotNull('attribute.attribute_id')
            ->orderBy('name', 'asc')
            ->orderBy('value', 'asc')
            ->pluck('fullname', 'id');
        /*return AttributeValue::leftJoin('attribute',
            'attribute_value.attribute_id', '=', 'attribute.attribute_id')
            ->select(
                'attribute.attribute_id as attribute_id',
                'attribute_value.attribute_value_id as attribute_value_id',
                'attribute_value.value as value',
                'attribute.name as name'
            )
            ->whereNotNull('attribute.attribute_id')
            ->orderBy('name', 'asc')
            ->orderBy('value', 'asc')
            ->get();*/
    }
}
