<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Quote;

use Siemendev\Checkout\Products\AdditionalCost\AdditionalCostInterface;

interface QuoteInterface
{
    public function getCurrency(): string;

    /** @return array<QuoteItemInterface> */
    public function getQuoteItems(): array;

    /** @return array<AdditionalCostInterface> */
    public function getAdditionalCosts(): array;

    public function getSubTotalNet(): int;

    public function getSubTotalGross(): int;

    public function getTotalNet(): int;

    public function getTotalGross(): int;
}
