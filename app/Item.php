<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    const STATUS_AVAILABLE = 'available';
    const STATUS_ASSIGNED = 'assigned';

    const PHYSICAL_STATUS_TO_ORDER = 'to order';
    const PHYSICAL_STATUS_IN_WAREHOUSE = 'in warehouse';
    const PHYSICAL_STATUS_DELIVERED = 'delivered';

    /**
     * No timestamps for this model.
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * Get the Order that owns this Item.
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    /**
     * Get the Product belonging to this Item.
     */
    public function product()
    {
        return $this->hasOne('App\Product');
    }
}
