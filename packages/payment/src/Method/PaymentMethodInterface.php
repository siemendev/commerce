<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Method;

use Siemendev\Checkout\Payment\Payment\PaymentInterface;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;

interface PaymentMethodInterface
{
    public function identifier(): string;

    /**
     * @throws PaymentMethodNotEligibleException
     */
    public function eligible(QuotedCheckoutDataInterface $data): void;

    public function isEligible(QuotedCheckoutDataInterface $data): bool;

    /**
     * @throws PaymentNotCapturableException
     */
    public function capture(PaymentInterface $payment): void;

    /**
     * @throws PaymentCaptureRollbackException
     */
    public function rollbackCapture(PaymentInterface $payment): void;
}
