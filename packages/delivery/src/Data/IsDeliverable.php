<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\Data;

use Siemendev\Checkout\Delivery\Option\DeliveryOptionInterface;
use Siemendev\Checkout\Step\Address\AddressInterface;

trait IsDeliverable
{
    private ?AddressInterface $deliveryAddress = null;

    private ?DeliveryOptionInterface $deliveryOption = null;

    public function setDeliveryAddress(?AddressInterface $deliveryAddress): static
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function getDeliveryAddress(): ?AddressInterface
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryOption(?DeliveryOptionInterface $deliveryOption): static
    {
        $this->deliveryOption = $deliveryOption;

        return $this;
    }

    public function getDeliveryOption(): ?DeliveryOptionInterface
    {
        return $this->deliveryOption;
    }
}
