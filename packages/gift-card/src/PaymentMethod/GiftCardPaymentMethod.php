<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\PaymentMethod;

use Siemendev\Checkout\GiftCard\Checker\GiftCardCheckerInterface;
use Siemendev\Checkout\GiftCard\Payment\GiftCardPaymentInterface;
use Siemendev\Checkout\GiftCard\Repository\GiftCardRepositoryInterface;
use Siemendev\Checkout\Payment\Method\AbstractPaymentMethod;
use Siemendev\Checkout\Payment\Method\PaymentCaptureRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentNotCapturableException;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;

/**
 * @implements GiftCardPaymentMethodInterface<GiftCardPaymentInterface>
 */
class GiftCardPaymentMethod extends AbstractPaymentMethod implements GiftCardPaymentMethodInterface
{
    private GiftCardRepositoryInterface $repository;

    /** @var array<GiftCardCheckerInterface> $checkers */
    private array $checkers = [];

    public function setRepository(GiftCardRepositoryInterface $repository): static
    {
        $this->repository = $repository;

        return $this;
    }

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

    public function identifier(): string
    {
        return GiftCardPaymentMethodInterface::IDENTIFIER;
    }

    public function eligible(QuotedCheckoutDataInterface $data): void
    {
        foreach ($this->checkers as $checker) {
            $checker->checkGiftCardPaymentAvailability($data);
        }
    }

    public function capture(PaymentInterface $payment): void
    {
        if (!$payment instanceof GiftCardPaymentInterface) {
            throw new PaymentNotCapturableException(sprintf(
                'The gift card payment method only works with your payment (%s) implementing %s',
                $payment::class,
                GiftCardPaymentInterface::class
            ));
        }

        $this->repository->redeem($payment);
    }

    public function rollbackCapture(PaymentInterface $payment): void
    {
        if (!$payment instanceof GiftCardPaymentInterface) {
            throw new PaymentCaptureRollbackException(sprintf(
                'The gift card payment method only works with your payment (%s) implementing %s',
                $payment::class,
                GiftCardPaymentInterface::class
            ));
        }

        $this->repository->rollback($payment);
    }
}
