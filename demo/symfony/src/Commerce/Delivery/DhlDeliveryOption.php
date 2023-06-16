<?php

declare(strict_types=1);

namespace App\Commerce\Delivery;

use Siemendev\Checkout\Delivery\Data\DeliverableCheckoutDataInterface;
use Siemendev\Checkout\Delivery\Option\AbstractDeliveryOption;
use Siemendev\Checkout\Delivery\Option\DeliveryOptionNotAvailableException;

/**
 * Example delivery option that is only available for specific countries (D-A-CH).
 * This is a very simple example, but imagine loading the pricing details from a database or API.
 */
class DhlDeliveryOption extends AbstractDeliveryOption
{
    public const IDENTIFIER = 'dhl';

    public const DHL_COSTS = [
        'DE' => 499,
        'AT' => 799,
        'CH' => 999,
    ];

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    public function checkAvailability(DeliverableCheckoutDataInterface $data): void
    {
        if (!isset(self::DHL_COSTS[$data->getDeliveryAddress()->getCountryCode()])) {
            throw new DeliveryOptionNotAvailableException('DHL is not available for this country.');
        }
    }

    public function getPriceNet(DeliverableCheckoutDataInterface $data): int
    {
        return self::DHL_COSTS[$data->getDeliveryAddress()->getCountryCode()];
    }

    public function getPriceGross(DeliverableCheckoutDataInterface $data): int
    {
        return self::DHL_COSTS[$data->getDeliveryAddress()->getCountryCode()];
    }
}
