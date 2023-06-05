<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Quote\Calculation;

use Siemendev\Checkout\Data\CheckoutDataInterface;

interface CheckoutQuoteCalculatorInterface
{
    public function calculate(CheckoutDataInterface $data): void;
}
