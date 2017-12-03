<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * No timestamps for this model.
     *
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'sku',
        'colour'
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'colour' => '-'
    ];

    /**
     * Get the Item this Product has.
     */
    public function item()
    {
        return $this->hasOne('App\Item');
    }
}
