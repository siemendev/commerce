<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address\Billing;

use Siemendev\Checkout\Step\Address\AddressInterface;

interface BillingAddressableCheckoutSessionInterface
{
    public function getBillingAddress(): ?AddressInterface;
}
