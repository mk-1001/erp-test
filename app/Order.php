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
     *
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'customer_name',
        'address'
    ];

    /**
     * Default attributes for orders.
     *
     * @var array
     */
    protected $attributes = [
        'status' => self::STATUS_IN_PROGRESS,
    ];

    /**
     * Get the items belonging to this order.
     */
    public function items()
    {
        return $this->hasMany('App\Item');
    }

    /**
     * Remove a certain Item from this order, and cancel the order if there are no more items.
     *
     * @param int $itemID
     */
    public function removeItem($itemID)
    {
        $this->items->each(function (Item $item) use ($itemID) {
            if ($item->id == $itemID) {
                $item->removeOrder();
            }
        });

        if ($this->items->count() - 1 === 0) {
            $this->cancelOrder();
        }
    }

    /**
     * Cancels the order.
     */
    public function cancelOrder()
    {
        $this->status = self::STATUS_CANCELLED;
        $this->save();
    }

    /**
     * Check if all items have been delivered.
     *
     * @return bool
     */
    public function allItemsHaveBeenDelivered()
    {
        foreach ($this->items as $item) {
            if (!$item->isDeliveredToCustomer()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if all items have been delivered, and update the Order status as appropriate.
     */
    public function updateDeliveredStatus()
    {
        if ($this->status == self::STATUS_CANCELLED) {
            return;
        }
        $expectedStatus = $this->allItemsHaveBeenDelivered() ? self::STATUS_COMPLETED : self::STATUS_IN_PROGRESS;
        if ($expectedStatus == $this->status) {
            return;
        }
        $this->status = $expectedStatus;
        $this->save();
    }
}
