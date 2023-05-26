<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address\Billing;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\Address\AddressInterface;

interface BillingAddressableCheckoutDataInterface extends CheckoutDataInterface
{
    public function getBillingAddress(): ?AddressInterface;
}
