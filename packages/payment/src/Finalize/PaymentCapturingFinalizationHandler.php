<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Finalize;

use InvalidArgumentException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Finalize\CheckoutFinalizationHandlerInterface;
use Siemendev\Checkout\Finalize\CheckoutFinalizerInterface;
use Siemendev\Checkout\Payment\Data\PaymentCheckoutDataInterface;
use Siemendev\Checkout\Payment\Method\PaymentCaptureRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentMethodsProviderInterface;
use Siemendev\Checkout\Payment\Method\PaymentNotCapturableException;

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

    public function finalize(CheckoutDataInterface $data): void
    {
        if (!$data instanceof PaymentCheckoutDataInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s needs to implement %s to finalize the payment.',
                    $data::class,
                    PaymentCheckoutDataInterface::class
                ),
            );
        }

        foreach ($data->getPayments() as $payment) {
            if ($payment->isCaptured()) {
                continue;
            }

            try {
                $this->paymentMethodsProvider
                    ->getPaymentMethod($payment->getPaymentMethodIdentifier())
                    ->capture($payment)
                ;
            } catch (PaymentNotCapturableException $e) {
                throw new PaymentNotCapturableCheckoutNotFinalizableException($e);
            }
        }
    }

    public function rollback(CheckoutDataInterface $data): void
    {
        $exceptions = [];
        foreach ($data->getPayments() as $payment) {
            if (!$payment->isCaptured()) {
                continue;
            }

            try {
                $this->paymentMethodsProvider
                    ->getPaymentMethod($payment->getPaymentMethodIdentifier())
                    ->rollbackCapture($payment);
            } catch (PaymentCaptureRollbackException $exception) {
                $exceptions[] = $exception;
            }
        }

        throw new PaymentsRollbackExceptionsCollection($exceptions);
    }
}
