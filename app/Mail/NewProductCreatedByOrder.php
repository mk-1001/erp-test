<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class NewProductCreatedByOrder
 * This email is sent to an administrator when a new product is created automatically, when an order is submitted.
 * @package App\Mail
 */
class NewProductCreatedByOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Collection $newProducts
     */
    protected $newProducts;

    /**
     * Create a new message instance.
     *
     * @param Collection $newProducts
     * @return void
     */
    public function __construct(Collection $newProducts)
    {
        $this->newProducts = $newProducts;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Product(s) have been created')->markdown('emails.products.newautomatic', [
            'products' => $this->newProducts
        ]);
    }
}
