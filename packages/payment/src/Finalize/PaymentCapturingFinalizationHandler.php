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
            /** @var PaymentInterface $payment */
            if ($payment->isCaptured()) {
                continue;
            }

            try {
                $this->paymentMethodsProvider
                    ->getPaymentMethod($payment->getPaymentMethodIdentifier())
                    ->capture($payment, $data)
                ;
                $payment->setCaptured(true);
            } catch (PaymentNotCapturableException $e) {
                throw new PaymentNotCapturableCheckoutNotFinalizableException($e);
            }
        }
    }

    public function rollback(CheckoutDataInterface $data): void
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

        $exceptions = [];
        foreach ($data->getPayments() as $payment) {
            /** @var PaymentInterface $payment */
            if (!$payment->isCaptured()) {
                continue;
            }

            try {
                $this->paymentMethodsProvider
                    ->getPaymentMethod($payment->getPaymentMethodIdentifier())
                    ->rollbackCapture($payment, $data)
                ;
                if (!$payment->isAuthorized()) {
                    $data->getPayments()->remove($payment);
                }
            } catch (PaymentCaptureRollbackException $exception) {
                $exceptions[] = $exception;
            }
        }

        throw new PaymentsRollbackExceptionsCollection($exceptions);
    }
}
