<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\AdditionalCost;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Quote\QuoteInterface;

interface AdditionalCostsAggregatorInterface
{
    /**
     * @return array<AdditionalCostInterface>
     */
    public function getAdditionalCost(CheckoutDataInterface $data, QuoteInterface $quote): array;
}
