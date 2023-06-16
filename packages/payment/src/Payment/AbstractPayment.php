<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Payment;

abstract class AbstractPayment implements PaymentInterface
{
    protected bool $authorized = false;

    protected bool $captured = false;

    private string $identifier;

    private int $authorizedAmount = 0;

    private int $capturedAmount = 0;

    private string $currency;

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getCapturedAmount(): int
    {
        return $this->capturedAmount;
    }

    public function setCapturedAmount(int $amount): static
    {
        $this->capturedAmount = $amount;

        return $this;
    }

    public function getAuthorizedAmount(): int
    {
        return $this->authorizedAmount;
    }

    public function setAuthorizedAmount(int $amount): static
    {
        $this->authorizedAmount = $amount;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function isAuthorized(): bool
    {
        return $this->authorized;
    }

    public function setAuthorized(bool $authorized): static
    {
        $this->authorized = $authorized;

        return $this;
    }

    public function isCaptured(): bool
    {
        return $this->captured;
    }

    public function setCaptured(bool $captured): static
    {
        $this->captured = $captured;

        return $this;
    }

    public function getPriority(): int
    {
        return static::PRIORITY_DEFAULT;
    }
}
