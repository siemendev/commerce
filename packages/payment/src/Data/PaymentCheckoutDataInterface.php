<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Data;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Payment\Payment\Collection\PaymentCollectionInterface;

interface PaymentCheckoutDataInterface extends CheckoutDataInterface
{
    public function getPayments(): PaymentCollectionInterface;
}
