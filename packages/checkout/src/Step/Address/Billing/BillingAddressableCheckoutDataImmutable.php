<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address\Billing;

use Siemendev\Checkout\Step\Address\AddressInterface;

trait BillingAddressableCheckoutDataImmutable
{
    private ?AddressInterface $billingAddress = null;

    public function getBillingAddress(): ?AddressInterface
    {
        return $this->billingAddress;
    }
}
