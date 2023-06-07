<?php declare(strict_types=1);

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

    /**
     * @return string
     */
    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    /**
     * @param string $cardNumber
     * @return CreditCardPayment
     */
    public function setCardNumber(string $cardNumber): CreditCardPayment
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardHolder(): string
    {
        return $this->cardHolder;
    }

    /**
     * @param string $cardHolder
     * @return CreditCardPayment
     */
    public function setCardHolder(string $cardHolder): CreditCardPayment
    {
        $this->cardHolder = $cardHolder;
        return $this;
    }

    /**
     * @return int
     */
    public function getCardExpiryMonth(): int
    {
        return $this->cardExpiryMonth;
    }

    /**
     * @param int $cardExpiryMonth
     * @return CreditCardPayment
     */
    public function setCardExpiryMonth(int $cardExpiryMonth): CreditCardPayment
    {
        $this->cardExpiryMonth = $cardExpiryMonth;
        return $this;
    }

    /**
     * @return int
     */
    public function getCardExpiryYear(): int
    {
        return $this->cardExpiryYear;
    }

    /**
     * @param int $cardExpiryYear
     * @return CreditCardPayment
     */
    public function setCardExpiryYear(int $cardExpiryYear): CreditCardPayment
    {
        $this->cardExpiryYear = $cardExpiryYear;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardCsc(): string
    {
        return $this->cardCsc;
    }

    /**
     * @param string $cardCsc
     * @return CreditCardPayment
     */
    public function setCardCsc(string $cardCsc): CreditCardPayment
    {
        $this->cardCsc = $cardCsc;
        return $this;
    }
}
