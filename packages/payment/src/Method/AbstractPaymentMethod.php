<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Method;

use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;

abstract class AbstractPaymentMethod implements PaymentMethodInterface
{
    public function isEligible(QuotedCheckoutDataInterface $data): bool
    {
        try {
            $this->eligible($data);
        } catch (PaymentMethodNotEligibleException) {
            return false;
        }

        return true;
    }
}
