<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Products\Data;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;

interface ProductCheckoutDataInterface extends CheckoutDataInterface
{
    // todo this should be a collection like PaymentsCollection to handle adding/removing products more consistent
    /**
     * @return array<ProductInterface>
     */
    public function getProducts(): array;
}
