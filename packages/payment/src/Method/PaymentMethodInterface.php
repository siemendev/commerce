<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Method;

use Siemendev\Checkout\Payment\Payment\PaymentInterface;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;

/**
 * @template T of PaymentInterface
 */
interface PaymentMethodInterface
{
    public function identifier(): string;

    /**
     * @throws PaymentMethodNotEligibleException
     */
    public function eligible(QuotedCheckoutDataInterface $data): void;

    public function isEligible(QuotedCheckoutDataInterface $data): bool;

    /**
     * @param T $payment
     * @throws PaymentNotCapturableException
     */
    public function capture(PaymentInterface $payment): void;

    /**
     * Payment capture roll-back
     * In case something goes wrong after the payment has been captured, we need to be able to roll back the capture.
     * In case your payment gateway only supports rolling back the whole payment (so the payment is no longer
     * authorized, not just the capture reverted) set $payment->setAuthorized(false) and the payment will automatically
     * be removed from the checkout payments.
     *
     * @param T $payment
     * @throws PaymentCaptureRollbackException
     */
    public function rollbackCapture(PaymentInterface $payment): void;
}
