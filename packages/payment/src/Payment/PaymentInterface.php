<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Payment;

use Siemendev\Checkout\Payment\Method\PaymentMethodInterface;

interface PaymentInterface
{
    public const PRIORITY_LOW = 50;
    public const PRIORITY_DEFAULT = 100;
    public const PRIORITY_HIGH = 150;

    public function getIdentifier(): string;

    /**
     * @see PaymentMethodInterface::getIdentifier()
     */
    public function getPaymentMethodIdentifier(): string;

    /**
     * The amount that has actually been captured. This can be less than the amount that has been authorized and will
     * not be set by the payment provider but automatically when the payments are captured.
     *
     * Please do not set this manually, always set the authorized amount instead.
     */
    public function getCapturedAmount(): int;

    public function setCapturedAmount(int $amount): static;

    public function getAuthorizedAmount(): int;

    public function getCurrency(): string;

    public function isAuthorized(): bool;

    public function setAuthorized(bool $authorized): static;

    public function isCaptured(): bool;

    public function setCaptured(bool $captured): static;

    public function getPriority(): int;
}
