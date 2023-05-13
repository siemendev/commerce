<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Delivery;

use Siemendev\Checkout\Step\Address\AddressInterface;
use Siemendev\Checkout\Step\Delivery\Type\DeliveryTypeInterface;

trait DeliverableCheckoutData
{
    private ?AddressInterface $deliveryAddress = null;

    private ?DeliveryTypeInterface $deliveryType = null;

    public function setDeliveryAddress(?AddressInterface $deliveryAddress): static
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function getDeliveryAddress(): ?AddressInterface
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryType(?DeliveryTypeInterface $deliveryType): static
    {
        $this->deliveryType = $deliveryType;

        return $this;
    }

    public function getDeliveryType(): ?DeliveryTypeInterface
    {
        return $this->deliveryType;
    }
}
