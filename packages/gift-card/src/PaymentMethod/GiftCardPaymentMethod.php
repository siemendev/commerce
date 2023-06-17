<?php

declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\PaymentMethod;

use Siemendev\Checkout\GiftCard\Checker\GiftCardCheckerInterface;
use Siemendev\Checkout\GiftCard\Payment\GiftCardPaymentInterface;
use Siemendev\Checkout\GiftCard\Payment\GiftCardPaymentManagerInterface;
use Siemendev\Checkout\Payment\Method\AbstractPaymentMethod;
use Siemendev\Checkout\Payment\Method\PaymentAuthorizationRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentCaptureRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentNotCapturableException;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;

/**
 * @extends AbstractPaymentMethod<GiftCardPaymentInterface>
 */
class GiftCardPaymentMethod extends AbstractPaymentMethod implements GiftCardPaymentMethodInterface
{
    private GiftCardPaymentManagerInterface $paymentManager;

    /** @var array<GiftCardCheckerInterface> */
    private array $checkers = [];

    public function setPaymentManager(GiftCardPaymentManagerInterface $paymentManager): static
    {
        $this->paymentManager = $paymentManager;

        return $this;
    }

    /**
     * @param array<GiftCardCheckerInterface> $checkers
     */
    public function setCheckers(array $checkers): static
    {
        $this->checkers = $checkers;

        return $this;
    }

    public function addChecker(GiftCardCheckerInterface $checker): static
    {
        $this->checkers[] = $checker;

        return $this;
    }

    public function getIdentifier(): string
    {
        return GiftCardPaymentMethodInterface::IDENTIFIER;
    }

    public function eligible(QuotedCheckoutDataInterface $data): void
    {
        foreach ($this->checkers as $checker) {
            $checker->checkGiftCardPaymentAvailability($data);
        }
    }

    public function capture(PaymentInterface $payment, QuotedCheckoutDataInterface $data, int $amount): void
    {
        if (!$payment instanceof GiftCardPaymentInterface) {
            throw new PaymentNotCapturableException(sprintf('The gift card payment method only works with your payment (%s) implementing %s', $payment::class, GiftCardPaymentInterface::class));
        }

        $this->paymentManager->redeem($payment, $data, $amount);
    }

    public function rollbackCapture(PaymentInterface $payment, QuotedCheckoutDataInterface $data): void
    {
        if (!$payment instanceof GiftCardPaymentInterface) {
            throw new PaymentCaptureRollbackException(sprintf('The gift card payment method only works with your payment (%s) implementing %s', $payment::class, GiftCardPaymentInterface::class));
        }

        $this->paymentManager->rollbackRedeem($payment, $data);
    }

    public function rollbackAuthorization(PaymentInterface $payment, QuotedCheckoutDataInterface $data): void
    {
        if (!$payment instanceof GiftCardPaymentInterface) {
            throw new PaymentAuthorizationRollbackException(sprintf('The gift card payment method only works with your payment (%s) implementing %s', $payment::class, GiftCardPaymentInterface::class));
        }

        $this->paymentManager->rollbackReservation($payment, $data);
    }
}
