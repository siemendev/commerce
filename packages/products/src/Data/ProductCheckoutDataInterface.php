<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Data;

use Siemendev\Checkout\Products\Payment\PaymentInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;

interface ProductCheckoutDataInterface
{
    /**
     * @return array<ProductInterface>
     */
    public function getProducts(): array;

    /**
     * @return array<PaymentInterface>
     */
    public function getPayments(): array;
}
