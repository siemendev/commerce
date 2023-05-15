<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Builder\Part;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Quote\QuoteInterface;

interface QuotePartBuilderInterface
{
    public function build(QuoteInterface $quote, CheckoutDataInterface $data): void;
}
