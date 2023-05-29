<?php declare(strict_types=1);

namespace App\Commerce\Delivery;

use Siemendev\Checkout\Delivery\Data\DeliverableCheckoutDataInterface;
use Siemendev\Checkout\Delivery\Option\AbstractDeliveryOption;
use Siemendev\Checkout\Delivery\Option\DeliveryOptionNotAvailableException;

/**
 * Example delivery option that is only available for specific countries (D-A-CH).
 */
class DhlDeliveryOption extends AbstractDeliveryOption
{
    public const IDENTIFIER = 'dhl';

    public const DHL_DELIVERABLE_COUNTRIES = ['DE', 'AT', 'CH'];

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    public function checkAvailability(DeliverableCheckoutDataInterface $data): void
    {
        if (!in_array($data->getDeliveryAddress()->getCountryCode(), self::DHL_DELIVERABLE_COUNTRIES)) {
            throw new DeliveryOptionNotAvailableException('DHL is not available for this country.');
        }
    }
}
