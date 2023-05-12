<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address\Delivery;

use Siemendev\Checkout\Step\Address\AddressInterface;

trait DeliveryAddressableCheckoutData
{
    private ?AddressInterface $deliveryAddress = null;

    public function setDeliveryAddress(?AddressInterface $deliveryAddress): static
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function getDeliveryAddress(): ?AddressInterface
    {
        return $this->deliveryAddress;
    }
}
