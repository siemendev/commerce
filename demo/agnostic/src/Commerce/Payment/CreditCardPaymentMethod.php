<?php

declare(strict_types=1);

namespace Demo\Commerce\Payment;

use Demo\Commerce\Data\CheckoutData;
use Exception;
use Demo\ObjectExporter\ObjectExporter;
use Siemendev\Checkout\Payment\Method\AbstractPaymentMethod;
use Siemendev\Checkout\Payment\Method\PaymentAuthorizationRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentCaptureRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentMethodNotEligibleException;
use Siemendev\Checkout\Payment\Method\PaymentNotCapturableException;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;

/**
 * @extends AbstractPaymentMethod<CreditCardPayment>
 */
class CreditCardPaymentMethod extends AbstractPaymentMethod
{
    private const CHAOS_MONKEY_FAILURE_RATE = 50; // how high is the probability that the chaos monkey strikes (in %)?

    public const IDENTIFIER = 'credit-card';

    public function __construct(
        private readonly ObjectExporter $objectExporter,
    ) {}

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    public function eligible(QuotedCheckoutDataInterface $data): void
    {
        if ($data->getQuote()->getTotalGross() < 1000) {
            throw new PaymentMethodNotEligibleException('Credit card payment is only available for orders 10€ and up');
        }
        if ($data->getQuote()->getTotalGross() > 100000) {
            throw new PaymentMethodNotEligibleException('Credit card payment is only available for orders up to 1000€');
        }
    }

    /**
     * @param CheckoutData $data
     * @throws Exception
     */
    public function capture(PaymentInterface $payment, QuotedCheckoutDataInterface $data, int $amount): void
    {
        // Call the api of your payment gateway here to capture the payment.
        // Throw a PaymentNotCapturableException if the payment could not be captured.

        // to test our implementation, we invite the chaos monkey to simulate a failure occasionally:
        if (random_int(0, 100) < self::CHAOS_MONKEY_FAILURE_RATE) {
            throw new PaymentNotCapturableException('Credit card payment could not be captured. The chaos monkey strikes again!');
        }

        $this->objectExporter->export((clone $payment)->setCapturedAmount($amount), sprintf('orders/%s/payments/%s.xml', $data->getIdentifier(), $payment->getIdentifier()));
    }

    /**
     * @param CheckoutData $data
     */
    public function rollbackCapture(PaymentInterface $payment, QuotedCheckoutDataInterface $data): void
    {
        // Call the api of your payment gateway here to roll back the captured payment.
        // Throw a PaymentCaptureRollbackException if the payment could not be rolled back.

        // to test our implementation, we invite the chaos monkey to simulate a failure occasionally:
        if (random_int(0, 100) < self::CHAOS_MONKEY_FAILURE_RATE) {
            throw new PaymentCaptureRollbackException('Credit card payment capture could not be rolled back. The chaos monkey strikes again!');
        }

        $this->objectExporter->remove(sprintf('orders/%s/payments/%s.xml', $data->getIdentifier(), $payment->getIdentifier()));
    }

    public function rollbackAuthorization(PaymentInterface $payment, QuotedCheckoutDataInterface $data): void
    {
        // Call the api of your payment gateway here to roll back the authorized payment.
        // Throw a PaymentAuthorizationRollbackException if the payment authorization could not be rolled back.

        // to test our implementation, we invite the chaos monkey to simulate a failure occasionally:
        if (random_int(0, 100) < self::CHAOS_MONKEY_FAILURE_RATE) {
            throw new PaymentAuthorizationRollbackException('Credit card payment authorization could not be rolled back. The chaos monkey strikes again!');
        }
    }
}
