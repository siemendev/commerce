<?php

declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\Payment;

use Siemendev\Checkout\GiftCard\PaymentMethod\GiftCardPaymentMethodInterface;
use Siemendev\Checkout\Payment\Payment\AbstractPayment;

class GiftCardPayment extends AbstractPayment implements GiftCardPaymentInterface
{
    private string $giftCardCode;

    public function getGiftCardCode(): string
    {
        return $this->giftCardCode;
    }

    public function setGiftCardCode(string $giftCardCode): self
    {
        $this->giftCardCode = $giftCardCode;

        return $this;
    }

    public function getPaymentMethodIdentifier(): string
    {
        return GiftCardPaymentMethodInterface::IDENTIFIER;
    }

    public function isAuthorized(): bool
    {
        return true;
    }

    public function getPriority(): int
    {
        return static::PRIORITY_HIGH; // gift cards should be used first
    }
}
