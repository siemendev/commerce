<?php

declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\Capture;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\GiftCard\Payment\GiftCardPaymentInterface;
use Siemendev\Checkout\Payment\Method\PaymentCaptureRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentNotCapturableException;

interface GiftCardCapturingManagerInterface
{
    /**
     * Redeem gift card
     * Redeems a gift card payment (e.g. decrease gift card value in database or via an api).
     *
     * @throws PaymentNotCapturableException
     */
    public function redeem(GiftCardPaymentInterface $payment, CheckoutDataInterface $data, int $amount): void;

    /**
     * Roll back gift card payment
     * Rolls back a gift card payment (e.g. reset gift card value in database or via an api).
     *
     * @throws PaymentCaptureRollbackException
     */
    public function rollback(GiftCardPaymentInterface $payment, CheckoutDataInterface $data): void;
}
