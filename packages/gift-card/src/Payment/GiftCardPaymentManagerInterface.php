<?php

declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\Payment;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Payment\Method\PaymentAuthorizationRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentCaptureRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentNotCapturableException;

interface GiftCardPaymentManagerInterface
{
    /**
     * Redeem gift card
     * Redeems a gift card payment (e.g. decrease gift card value in database or via an api).
     *
     * @throws PaymentNotCapturableException
     */
    public function redeem(GiftCardPaymentInterface $payment, CheckoutDataInterface $data, int $amount): void;

    /**
     * Roll back redeemed gift card
     * Rolls back a redeemed gift card payment (e.g. reset gift card value in database or via an api).
     *
     * @throws PaymentCaptureRollbackException
     */
    public function rollbackRedeem(GiftCardPaymentInterface $payment, CheckoutDataInterface $data): void;

    /**
     * Roll back reservation of gift card
     * Rolls back a reserved gift card (e.g. free up reserved balance on gift card in database or via an api).
     *
     * @throws PaymentAuthorizationRollbackException
     */
    public function rollbackReservation(GiftCardPaymentInterface $payment, CheckoutDataInterface $data): void;
}
