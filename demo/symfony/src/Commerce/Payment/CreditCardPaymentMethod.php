<?php declare(strict_types=1);

namespace App\Commerce\Payment;

use Siemendev\Checkout\Payment\Method\AbstractPaymentMethod;
use Siemendev\Checkout\Payment\Method\PaymentMethodNotEligibleException;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;

class CreditCardPaymentMethod extends AbstractPaymentMethod
{
    public const IDENTIFIER = 'credit-card';

    public function identifier(): string
    {
        return self::IDENTIFIER;
    }

    public function eligible(QuotedCheckoutDataInterface $data): void
    {
        if ($data->getQuote()->getTotalGross() < 1000) {
            throw new PaymentMethodNotEligibleException('Credit card payment is only available for orders 10€ and up');
        }
        if ($data->getQuote()->getTotalGross() > 100000) {
            throw new PaymentMethodNotEligibleException('Credit card payment is only available for orders up to 1000€');
        }
    }
}
