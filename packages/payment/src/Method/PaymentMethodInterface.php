<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Method;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Quote\QuoteInterface;

interface PaymentMethodInterface
{
    public function identifier(): string;

    /**
     * @throws PaymentMethodNotEligibleException
     */
    public function eligible(CheckoutDataInterface $data, QuoteInterface $quote): void;

    public function isEligible(CheckoutDataInterface $data, QuoteInterface $quote): bool;
}
