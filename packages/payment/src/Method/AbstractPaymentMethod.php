<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Method;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Quote\QuoteInterface;

abstract class AbstractPaymentMethod implements PaymentMethodInterface
{
    public function isEligible(CheckoutDataInterface $data, QuoteInterface $quote): bool
    {
        try {
            $this->eligible($data, $quote);
        } catch (PaymentMethodNotEligibleException) {
            return false;
        }

        return true;
    }
}
