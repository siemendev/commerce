<?php declare(strict_types=1);

namespace App\Commerce\Provider\Payment;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Payment\Method\AbstractPaymentMethod;
use Siemendev\Checkout\Payment\Method\PaymentMethodNotEligibleException;
use Siemendev\Checkout\Products\Quote\QuoteInterface;

class InvoicePaymentMethod extends AbstractPaymentMethod
{
    public const IDENTIFIER = 'invoice';

    public function identifier(): string
    {
        return self::IDENTIFIER;
    }

    public function eligible(CheckoutDataInterface $data, QuoteInterface $quote): void
    {
        if ($quote->getTotalGross() > 100000) {
            throw new PaymentMethodNotEligibleException('Invoice payment is only available for orders up to 1000€');
        }
    }
}
