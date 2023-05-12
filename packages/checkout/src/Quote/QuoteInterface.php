<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote;

use Siemendev\Checkout\Quote\Action\QuoteActionInterface;
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
}
