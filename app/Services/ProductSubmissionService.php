<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use App\Product;
use App\Jobs\SendProductCreatedAdminEmail;

/**
 * Class ProductSubmissionService
 * This class provides a service for finding or creating products.
 * @package App\Services
 */
class ProductSubmissionService
{
    /**
     * Get Products by SKU, or makes new Products if necessary, and informs the administrator of any new Products.
     * Checks that each SKU is only specified once.
     * This method could be extracted to a Products-related service if necessary.
     *
     * @param array $requiredProductsInput (containing arrays with key: sku and colour (optional)
     * @return Collection $allProducts
     */
    public function findOrCreateProducts(array $requiredProductsInput)
    {
        $newlyCreatedProducts = new Collection();
        $allProducts = new Collection();

        collect($requiredProductsInput)->map(function (array $productInput) use ($newlyCreatedProducts, $allProducts) {
            // Important note: not using firstOrCreate, because the colour might be specified for the new Product.
            $product = Product::where([
                'sku' => $productInput['sku']
            ])->first();
            if (!$product) {
                // Create a new product if it doesn't exist
                $product = Product::create($productInput);
                $newlyCreatedProducts->add($product);
            }
            $allProducts->add($product);
            return $product;
        });
        if ($newlyCreatedProducts->count()) {
            $this->sendNewProductsCreatedMail($newlyCreatedProducts);
        }
        return $allProducts;
    }

    /**
     * Send an email through the SendProductCreatedAdminEmail job, informing the administrator that new Product(s)
     * have been created.
     *
     * @param Collection $newlyCreatedProducts
     */
    public function sendNewProductsCreatedMail(Collection $newlyCreatedProducts)
    {
        SendProductCreatedAdminEmail::dispatch($newlyCreatedProducts);
    }
}