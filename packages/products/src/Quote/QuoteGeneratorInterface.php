<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Quote;

use Siemendev\Checkout\Data\CheckoutDataInterface;

interface QuoteGeneratorInterface
{
    public function generate(CheckoutDataInterface $data): QuoteInterface;
}
