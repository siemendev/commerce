<?php declare(strict_types=1);

namespace App\Commerce\Payment;

use App\ObjectExporter\ObjectExporter;
use Exception;
use Siemendev\Checkout\Payment\Method\AbstractPaymentMethod;
use Siemendev\Checkout\Payment\Method\PaymentCaptureRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentMethodInterface;
use Siemendev\Checkout\Payment\Method\PaymentMethodNotEligibleException;
use Siemendev\Checkout\Payment\Method\PaymentNotCapturableException;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;

/**
 * @implements PaymentMethodInterface<CreditCardPayment>
 */
class CreditCardPaymentMethod extends AbstractPaymentMethod
{
    private const CHAOS_MONKEY_FAILURE_RATE = 50; // how high is the probability that the chaos monkey strikes (in %)?

    public const IDENTIFIER = 'credit-card';

    public function __construct(
        private readonly ObjectExporter $objectExporter,
    ) {
    }

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
     * @inheritDoc
     * @throws Exception
     */
    public function capture(PaymentInterface $payment, QuotedCheckoutDataInterface $data): void
    {
        // Call the api of your payment gateway here to capture the payment.
        // Throw a PaymentNotCapturableException if the payment could not be captured.

        // to test our implementation, we invite the chaos monkey to simulate a failure occasionally:
        if (random_int(0, 100) < self::CHAOS_MONKEY_FAILURE_RATE) {
            throw new PaymentNotCapturableException('Credit card payment could not be captured. The chaos monkey strikes again!');
        }

        $this->objectExporter->export($payment, sprintf('orders/%s/payments/%s.xml', $data->getIdentifier(), $payment->getIdentifier()));
    }

    public function rollbackCapture(PaymentInterface $payment, QuotedCheckoutDataInterface $data): void
    {
        // Call the api of your payment gateway here to roll back the captured payment.
        // Throw a PaymentCaptureRollbackException if the payment could not be rolled back.

        // to test our implementation, we invite the chaos monkey to simulate a failure occasionally:
        if (random_int(0, 100) < self::CHAOS_MONKEY_FAILURE_RATE) {
            throw new PaymentCaptureRollbackException('Credit card payment could not be rolled back. The chaos monkey strikes again!');
        }

        $this->objectExporter->remove(sprintf('orders/%s/payments/%s.xml', $data->getIdentifier(), $payment->getIdentifier()));
    }
}
