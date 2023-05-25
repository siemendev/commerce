<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\AdditionalCost;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Quote\QuoteInterface;

interface AdditionalCostProviderInterface
{
    public function eligible(CheckoutDataInterface $data): bool;

    /** @return array<AdditionalCostInterface> */
    public function getAdditionalCosts(CheckoutDataInterface $data, QuoteInterface $quote): array;
}
