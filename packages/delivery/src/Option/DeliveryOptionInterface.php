<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\Option;

use Siemendev\Checkout\Delivery\Data\DeliverableCheckoutDataInterface;

interface DeliveryOptionInterface
{
    /**
     * Get identifier
     * Returns the unique identifier of the delivery option.
     */
    public function getIdentifier(): string;

    /**
     * Is available
     * Shorthand method for checkAvailability() without the need to catch the exception.
     */
    public function isAvailable(DeliverableCheckoutDataInterface $data): bool;

    /**
     * Check availability
     * Checks if the delivery option is available for the given checkout data.
     * Throws an exception when the option is available, voids when everything is fine.
     *
     * @throws DeliveryOptionNotAvailableException
     */
    public function checkAvailability(DeliverableCheckoutDataInterface $data): void;

    /**
     * Get price (net)
     * Returns the net price of the delivery option. Price is in the currency of the checkout data ($data->getCurrency()).
     */
    public function getPriceNet(DeliverableCheckoutDataInterface $data): int;

    /**
     * Get price (gross)
     * Returns the gross price of the delivery option. Price is in the currency of the checkout data ($data->getCurrency()).
     */
    public function getPriceGross(DeliverableCheckoutDataInterface $data): int;
}
