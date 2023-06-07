<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\PayPal;

use Siemendev\Checkout\Payment\Payment\AbstractPayment;

class PayPalPayment extends AbstractPayment
{
    private ?string $paypalOrderId = null;

    public function getPaymentMethodIdentifier(): string
    {
        return 'paypal';
    }

    public function getPayPalOrderId(): ?string
    {
        return $this->paypalOrderId;
    }

    public function setPayPalOrderId(?string $paypalOrderId): static
    {
        $this->paypalOrderId = $paypalOrderId;

        return $this;
    }
}
