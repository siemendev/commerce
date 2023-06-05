<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Payment;

use Siemendev\Checkout\Payment\Method\PaymentMethodInterface;

interface PaymentInterface
{
    public function getIdentifier(): string;

    /**
     * @see PaymentMethodInterface::identifier()
     */
    public function getPaymentMethodIdentifier(): string;

    public function getAmount(): int;

    public function getCurrency(): string;

    public function isAuthorized(): bool;

    public function isCaptured(): bool;
}
