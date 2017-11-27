<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * No timestamps for this model.
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * Get the items belonging to this order.
     */
    public function items()
    {
        return $this->hasMany('App\Item');
    }
}
