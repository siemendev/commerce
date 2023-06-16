<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\Data;

use Siemendev\Checkout\Delivery\Option\DeliveryOptionInterface;
use Siemendev\Checkout\Step\Address\AddressInterface;

trait IsDeliverableImmutable
{
    private ?AddressInterface $deliveryAddress = null;

    private ?DeliveryOptionInterface $deliveryOption = null;

    public function getDeliveryAddress(): ?AddressInterface
    {
        return $this->deliveryAddress;
    }

    public function getDeliveryOption(): ?DeliveryOptionInterface
    {
        return $this->deliveryOption;
    }
}
