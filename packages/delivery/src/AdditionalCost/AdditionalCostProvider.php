<?php

declare(strict_types=1);

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
                && null !== $data->getDeliveryOption()
                && $data->getDeliveryOption()->getPriceNet($data) > 0;
        }

        /**
         * @param DeliverableCheckoutDataInterface $data
         */
        public function getAdditionalCosts(CheckoutDataInterface $data, QuoteInterface $quote): array // @phpstan-ignore-line
        {
            /** @var DeliveryOptionInterface $option */
            $option = $data->getDeliveryOption();

            return [
                new DeliveryAdditionalCost($option->getIdentifier(), $option->getPriceNet($data), $option->getPriceGross($data)),
            ];
        }
    }
}
