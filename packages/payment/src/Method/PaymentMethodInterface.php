<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Method;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;
use Siemendev\Checkout\Products\Quote\QuoteInterface;

interface PaymentMethodInterface
{
    public function identifier(): string;

    /**
     * @throws PaymentMethodNotEligibleException
     */
    public function eligible(QuotedCheckoutDataInterface $data): void;

    public function isEligible(QuotedCheckoutDataInterface $data): bool;
}
