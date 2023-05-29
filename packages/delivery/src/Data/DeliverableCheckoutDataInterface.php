<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\Data;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Delivery\Option\DeliveryOptionInterface;
use Siemendev\Checkout\Step\Address\AddressInterface;

interface DeliverableCheckoutDataInterface extends CheckoutDataInterface
{
    public function getDeliveryAddress(): ?AddressInterface;

    public function getDeliveryOption(): ?DeliveryOptionInterface;
}
