<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Finalize;

use InvalidArgumentException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Finalize\CheckoutFinalizationHandlerInterface;
use Siemendev\Checkout\Finalize\CheckoutFinalizerInterface;
use Siemendev\Checkout\Payment\Data\PaymentCheckoutDataInterface;
use Siemendev\Checkout\Payment\Method\PaymentCaptureRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentMethodsProviderInterface;
use Siemendev\Checkout\Payment\Method\PaymentNotCapturableException;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;

class PaymentCapturingFinalizationHandler implements CheckoutFinalizationHandlerInterface
{
    public function __construct(
        private PaymentMethodsProviderInterface $paymentMethodsProvider,
    ) {
    }

    public function setPaymentMethodsProvider(PaymentMethodsProviderInterface $paymentMethodsProvider): static
    {
        $this->paymentMethodsProvider = $paymentMethodsProvider;

        return $this;
    }

    public function step(): string
    {
        return CheckoutFinalizerInterface::FINALIZATION_STEP_PAYMENT;
    }

    /**
     * {@inheritDoc}
     * @throws PaymentNotCapturableCheckoutNotFinalizableException
     */
    public function finalize(CheckoutDataInterface $data): void
    {
        if (!$data instanceof PaymentCheckoutDataInterface) {
            throw new InvalidArgumentException(sprintf('%s needs to implement %s to finalize the payment.', $data::class, PaymentCheckoutDataInterface::class));
        }

        $leftTotal = $data->getQuote()->getTotalGross();

        $capturedPayments = [];
        foreach ($data->getPayments()->getCaptured() as $capturedPayment) {
            $capturedPayments[] = $capturedPayment;
            $leftTotal -= $capturedPayment->getCapturedAmount();
        }

        foreach ($data->getPayments()->getPrioritized() as $payment) {
            if ($payment->isCaptured()) {
                continue;
            }

            try {
                $captureAmount = $leftTotal > $payment->getAuthorizedAmount() ? $payment->getAuthorizedAmount() : $leftTotal;
                $this->paymentMethodsProvider
                    ->getPaymentMethod($payment->getPaymentMethodIdentifier())
                    ->capture($payment, $data, $captureAmount)
                ;
                $payment
                    ->setCaptured(true)
                    ->setCapturedAmount($captureAmount)
                ;
                $leftTotal -= $captureAmount;
                $capturedPayments[] = $payment;
            } catch (PaymentNotCapturableException $paymentException) {
                $rollbackExceptions = [];
                foreach ($capturedPayments as $capturedPayment) {
                    try {
                        $this->rollbackPayment($capturedPayment, $data);
                    } catch (PaymentCaptureRollbackException $rollbackException) {
                        $rollbackExceptions[] = $rollbackException;
                    }
                }

                throw new PaymentNotCapturableCheckoutNotFinalizableException($paymentException, $rollbackExceptions);
            }
        }
    }

    public function rollback(CheckoutDataInterface $data): void
    {
        if (!$data instanceof PaymentCheckoutDataInterface) {
            throw new InvalidArgumentException(sprintf('%s needs to implement %s to finalize the payment.', $data::class, PaymentCheckoutDataInterface::class));
        }

        $exceptions = [];
        foreach ($data->getPayments() as $payment) {
            /** @var PaymentInterface $payment */
            if (!$payment->isCaptured()) {
                continue;
            }

            try {
                $this->rollbackPayment($payment, $data);
            } catch (PaymentCaptureRollbackException $exception) {
                $exceptions[] = $exception;
            }
        }

        if (count($exceptions) > 0) {
            throw new PaymentsRollbackExceptionsCollection($exceptions);
        }
    }

    /**
     * @throws PaymentCaptureRollbackException
     */
    private function rollbackPayment(PaymentInterface $payment, PaymentCheckoutDataInterface $data): void
    {
        $this->paymentMethodsProvider
            ->getPaymentMethod($payment->getPaymentMethodIdentifier())
            ->rollbackCapture($payment, $data)
        ;
        if (!$payment->isAuthorized()) {
            $data->getPayments()->remove($payment);

            return;
        }

        $payment->setCaptured(false);
    }
}
