<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Action;

use Siemendev\Checkout\Item\Product\ProductInterface;

class RemoveProductQuoteAction implements QuoteActionInterface
{
    public const REASON_UNAVAILABLE = 'unavailable';

    public function __construct(
        public readonly ProductInterface $product,
        public readonly string $reason,
    ) {
    }
}
