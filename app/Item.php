<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    const STATUS_ASSIGNED = 'assigned';
    const STATUS_AVAILABLE = 'available';

    const PHYSICAL_STATUS_TO_ORDER = 'to order';
    const PHYSICAL_STATUS_IN_WAREHOUSE = 'in warehouse';
    const PHYSICAL_STATUS_DELIVERED = 'delivered';

    const PHYSICAL_STATUSES = [
        self::PHYSICAL_STATUS_TO_ORDER,
        self::PHYSICAL_STATUS_IN_WAREHOUSE,
        self::PHYSICAL_STATUS_DELIVERED
    ];

    const PHYSICAL_STATUSES_WITHOUT_ORDER = [
        self::PHYSICAL_STATUS_TO_ORDER,
        self::PHYSICAL_STATUS_IN_WAREHOUSE
    ];

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
        'order_id',
        'product_id',
        'physical_status'
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'physical_status' => self::PHYSICAL_STATUS_TO_ORDER
    ];

    /**
     * Attributes to be appended.
     * @var array
     */
    protected $appends = [
        'status'
    ];

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
        return $this->belongsTo('App\Product');
    }

    /**
     * Get the status attribute, as determined by whether an order_id exists.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->order ? self::STATUS_ASSIGNED : self::STATUS_AVAILABLE;
    }

    /**
     * Get the physical_status values that are allowed for this item.
     *
     * @return array
     */
    public function getAllowedPhysicalStatuses()
    {
        return $this->order ? self::PHYSICAL_STATUSES : self::PHYSICAL_STATUSES_WITHOUT_ORDER;
    }

    /**
     * Scope a query to only include items available for ordering (Builder::availableForNewOrder()).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailableForNewOrder($query)
    {
        return $query->where('order_id', null);
    }

    /**
     * Remove this item from an order, after checking that order ID is related.
     */
    public function removeOrder()
    {
        $this->order()->dissociate();
        $this->save();
    }

    /**
     * Has this Item been delivered?
     *
     * @return bool
     */
    public function isDeliveredToCustomer()
    {
        return $this->physical_status == self::PHYSICAL_STATUS_DELIVERED;
    }
}
