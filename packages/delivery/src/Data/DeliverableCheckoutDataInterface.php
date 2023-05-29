<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\Data;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Delivery\Type\DeliveryTypeInterface;
use Siemendev\Checkout\Step\Address\AddressInterface;

interface DeliverableCheckoutDataInterface extends CheckoutDataInterface
{
    public function getDeliveryAddress(): ?AddressInterface;

    public function getDeliveryType(): ?DeliveryTypeInterface;
}
