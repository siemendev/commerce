<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote;

use Siemendev\Checkout\Quote\Action\QuoteActionInterface;
use Siemendev\Checkout\Quote\AdditionalCost\QuoteAdditionalCostInterface;
use Siemendev\Checkout\Quote\Product\ProductQuoteInterface;
use Siemendev\Checkout\Quote\Subscription\SubscriptionQuoteInterface;

interface QuoteInterface
{
    /** @return array<ProductQuoteInterface> */
    public function getProducts(): array;

    /** @return array<SubscriptionQuoteInterface> */
    public function getSubscriptions(): array;

    /** @return array<QuoteActionInterface> */
    public function getActions(): array;

    /** @return array<QuoteAdditionalCostInterface> */
    public function getAdditionalCosts(): array;

    public function getSubTotalNet(): int;

    public function getSubTotalGross(): int;

    public function getTotalNet(): int;

    public function getTotalGross(): int;
}
