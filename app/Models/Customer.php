<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    /*
     * ELOQUENT CONFIG
     */
    const FIELDS_LABELS = [
        'customer_id' => 'Customer',
        'name' => 'Name',
        'email' => 'Email',
        'password' => 'Password',
        'credit_card' => 'Credit card',
        'address_1' => 'Address 1',
        'address_2' => 'Address 2',
        'city' => 'City',
        'region' => 'Region',
        'postal_code' => 'Postal code',
        'country' => 'Country',
        'shipping_region_id' => 'Shipping region',
        'day_phone' => 'Day phone',
        'eve_phone' => 'Evening phone',
        'mob_phone' => 'Mobile phone',
        'shipping_id' => 'Shipping Type'
    ];

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'name', 'email', 'password', 'credit_card', 'address_1', 'address_2', 'city', 'region',
        'postal_code', 'country', 'shipping_region_id', 'day_phone', 'eve_phone', 'mob_phone'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    protected $table = 'customer';

    public function getKeyName()
    {
        return 'customer_id';
    }

    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute) {
            parent::setAttribute($key, $value);
        }
    }

    /*
     * ELOQUENT METHODS OVERRIDE
     */
    public function delete()
    {
        $result = \DB::raw("call catalog_delete_customer($this->id)");
        return is_null(object_get($result[0], '-1'));
    }

    /*
     * HELPERS
     */
    public function getIdAttribute()
    {
        return $this->customer_id;
    }
}
