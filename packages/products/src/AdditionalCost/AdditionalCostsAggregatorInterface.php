<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\AdditionalCost;

use Siemendev\Checkout\Data\CheckoutDataInterface;

interface AdditionalCostsAggregatorInterface
{
    /**
     * @return array<AdditionalCostInterface>
     */
    public function getAdditionalCost(CheckoutDataInterface $data): array;
}
