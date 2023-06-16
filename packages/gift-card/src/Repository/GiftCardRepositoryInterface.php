<?php

declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\Repository;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\GiftCard\Payment\GiftCardPaymentInterface;

interface GiftCardRepositoryInterface
{
    /**
     * Redeem gift card
     * Redeems a gift card payment (e.g. decrease gift card value in database or via an api).
     */
    public function redeem(GiftCardPaymentInterface $payment, CheckoutDataInterface $data, int $amount): void;

    /**
     * Roll back gift card payment
     * Rolls back a gift card payment (e.g. reset gift card value in database or via an api).
     */
    public function rollback(GiftCardPaymentInterface $payment, CheckoutDataInterface $data): void;
}
