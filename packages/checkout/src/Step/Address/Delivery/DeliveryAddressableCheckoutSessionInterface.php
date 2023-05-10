<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address\Delivery;

use Siemendev\Checkout\Step\Address\AddressInterface;

interface DeliveryAddressableCheckoutSessionInterface
{
    public function getDeliveryAddress(): ?AddressInterface;
}
