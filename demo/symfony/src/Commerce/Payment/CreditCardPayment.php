<?php

declare(strict_types=1);

namespace App\Commerce\Payment;

use Siemendev\Checkout\Payment\Payment\AbstractPayment;

class CreditCardPayment extends AbstractPayment
{
    private string $cardNumber;

    private string $cardHolder;

    private int $cardExpiryMonth;

    private int $cardExpiryYear;

    private string $cardCsc;

    public function getPaymentMethodIdentifier(): string
    {
        return CreditCardPaymentMethod::IDENTIFIER;
    }

    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    public function setCardNumber(string $cardNumber): CreditCardPayment
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    public function getCardHolder(): string
    {
        return $this->cardHolder;
    }

    public function setCardHolder(string $cardHolder): CreditCardPayment
    {
        $this->cardHolder = $cardHolder;

        return $this;
    }

    public function getCardExpiryMonth(): int
    {
        return $this->cardExpiryMonth;
    }

    public function setCardExpiryMonth(int $cardExpiryMonth): CreditCardPayment
    {
        $this->cardExpiryMonth = $cardExpiryMonth;

        return $this;
    }

    public function getCardExpiryYear(): int
    {
        return $this->cardExpiryYear;
    }

    public function setCardExpiryYear(int $cardExpiryYear): CreditCardPayment
    {
        $this->cardExpiryYear = $cardExpiryYear;

        return $this;
    }

    public function getCardCsc(): string
    {
        return $this->cardCsc;
    }

    public function setCardCsc(string $cardCsc): CreditCardPayment
    {
        $this->cardCsc = $cardCsc;

        return $this;
    }
}
