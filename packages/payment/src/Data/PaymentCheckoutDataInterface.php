<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Data;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;

interface PaymentCheckoutDataInterface extends CheckoutDataInterface
{
    /**
     * @return array<PaymentInterface>
     */
    public function getPayments(): array;
}
