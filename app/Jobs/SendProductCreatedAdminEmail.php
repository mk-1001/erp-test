<?php

namespace App\Jobs;

use App\Mail\NewProductCreatedByOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

/**
 * Class SendProductCreatedAdminEmail
 * This class is responsible for sending an email to the site administrator when a new product has been created.
 * @package App\Jobs
 */
class SendProductCreatedAdminEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Collection $newProducts
     */
    protected $newProducts;

    /**
     * Create a new job instance.
     *
     * @param Collection $newProducts
     * @return void
     */
    public function __construct(Collection $newProducts)
    {
        $this->newProducts = $newProducts;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $toAddress = config('mail.from.address');
        Mail::to($toAddress)->send(new NewProductCreatedByOrder($this->newProducts));
    }
}
