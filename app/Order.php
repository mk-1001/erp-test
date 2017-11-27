<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_CANCELLED = 'Cancelled';
    const STATUS_IN_PROGRESS = 'In Progress';
    const STATUS_COMPLETED = 'Completed';

    /**
     * No timestamps for this model.
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * Default attributes for orders.
     * @var array
     */
    protected $attributes = [
        'status' => self::STATUS_IN_PROGRESS
    ];

    /**
     * Get the items belonging to this order.
     */
    public function items()
    {
        return $this->hasMany('App\Item');
    }
}
