<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Delivery;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\Address\AddressInterface;
use Siemendev\Checkout\Step\Delivery\Type\DeliveryTypeInterface;

interface DeliverableCheckoutDataInterface extends CheckoutDataInterface
{
    public function getDeliveryAddress(): ?AddressInterface;

    public function getDeliveryType(): ?DeliveryTypeInterface;
}
