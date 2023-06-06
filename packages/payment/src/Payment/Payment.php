<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Payment;

class Payment implements PaymentInterface
{
    protected bool $authorized = false;
    protected bool $captured = false;

    private string $paymentMethodIdentifier;
    private string $identifier;
    private int $amount;
    private string $currency;

    public function setPaymentMethodIdentifier(string $paymentMethodIdentifier): static
    {
        $this->paymentMethodIdentifier = $paymentMethodIdentifier;

        return $this;
    }

    public function getPaymentMethodIdentifier(): string
    {
        return $this->paymentMethodIdentifier;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

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

    public function authorized(): static
    {
        $this->authorized = true;

        return $this;
    }

    public function isCaptured(): bool
    {
        return $this->captured;
    }

    public function captured(): static
    {
        $this->authorized = true;
        $this->captured = true;

        return $this;
    }
}
