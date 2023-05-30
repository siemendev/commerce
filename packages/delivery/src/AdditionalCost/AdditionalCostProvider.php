<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\AdditionalCost;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Delivery\Data\DeliverableCheckoutDataInterface;
use Siemendev\Checkout\Delivery\Option\DeliveryOptionInterface;
use Siemendev\Checkout\Products\AdditionalCost\AdditionalCostProviderInterface;
use Siemendev\Checkout\Products\Quote\QuoteInterface;

if (interface_exists(AdditionalCostProviderInterface::class)) {
    class AdditionalCostProvider implements AdditionalCostProviderInterface
    {
        public function eligible(CheckoutDataInterface $data): bool
        {
            return $data instanceof DeliverableCheckoutDataInterface
                && $data->getDeliveryOption() !== null
                && $data->getDeliveryOption()->getPriceNet($data) > 0
            ;
        }

        public function getAdditionalCosts(CheckoutDataInterface $data, QuoteInterface $quote): array
        {
            /** @var DeliveryOptionInterface $option */
            $option = $data->getDeliveryOption(); // not polymorph, eligible() ensures that this is not null

            return [
                new DeliveryAdditionalCost($option->getIdentifier(), $option->getPriceNet($data), $option->getPriceGross($data)),
            ];
        }
    }
}
