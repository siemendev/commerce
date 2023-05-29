<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\Option;

use Siemendev\Checkout\Delivery\Data\DeliverableCheckoutDataInterface;

abstract class AbstractDeliveryOption implements DeliveryOptionInterface
{
    public function isAvailable(DeliverableCheckoutDataInterface $data): bool
    {
        try {
            $this->checkAvailability($data);
        } catch (DeliveryOptionNotAvailableException) {
            return false;
        }

        return true;
    }
}
