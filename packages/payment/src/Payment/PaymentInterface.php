<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment;

interface PaymentInterface
{
    public function getIdentifier(): string;

    public static function getPaymentMethodIdentifier(): string;

    public function getAmount(): int;

    public function getCurrency(): string;
}
