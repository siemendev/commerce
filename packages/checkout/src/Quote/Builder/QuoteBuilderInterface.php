<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Builder;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Quote\Quote;

interface QuoteBuilderInterface
{
    public function getQuoteByCheckoutData(CheckoutDataInterface $data): Quote;
}
