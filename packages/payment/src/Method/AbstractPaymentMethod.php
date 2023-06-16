<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Method;

use Siemendev\Checkout\Payment\Payment\PaymentInterface;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;

/**
 * @template T of PaymentInterface
 * @implements PaymentMethodInterface<T>
 */
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
