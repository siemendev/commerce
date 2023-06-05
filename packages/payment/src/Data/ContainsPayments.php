<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Data;

use Siemendev\Checkout\Payment\Payment\Collection\PaymentCollection;
use Siemendev\Checkout\Payment\Payment\Collection\PaymentCollectionInterface;

/**
 * @see PaymentCheckoutDataInterface
 */
trait ContainsPayments
{
    public PaymentCollectionInterface $payments;

    public function getPayments(): PaymentCollectionInterface
    {
        return $this->payments ?? ($this->payments = new PaymentCollection());
    }
}
