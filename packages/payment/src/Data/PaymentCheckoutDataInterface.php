<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Data;

use Siemendev\Checkout\Payment\Payment\Collection\PaymentCollectionInterface;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;

interface PaymentCheckoutDataInterface extends QuotedCheckoutDataInterface
{
    public function getPayments(): PaymentCollectionInterface;

    /**
     * Convenience method to get the total amount that still needs payment.
     */
    public function getOpenTotal(): int;
}
