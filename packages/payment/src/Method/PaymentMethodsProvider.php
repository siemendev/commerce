<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Method;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Payment\Data\PaymentCheckoutDataInterface;
use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;

class PaymentMethodsProvider implements PaymentMethodsProviderInterface
{
    /**
     * @param array<PaymentMethodInterface> $paymentMethods
     */
    public function __construct(
        private array $paymentMethods = [],
    ) {
    }

    /**
     * @param array<PaymentMethodInterface> $paymentMethods
     */
    public function setPaymentMethods(array $paymentMethods): void
    {
        $this->paymentMethods = $paymentMethods;
    }

    public function addPaymentMethod(PaymentMethodInterface $paymentMethod): static
    {
        $this->paymentMethods[] = $paymentMethod;

        return $this;
    }

    public function getEligiblePaymentMethods(CheckoutDataInterface $data): array
    {
        if (!$data instanceof QuotedCheckoutDataInterface) {
            throw new LogicException(sprintf('%s needs to implement %s to check the eligibility of payment methods.', $data::class, QuotedCheckoutDataInterface::class));
        }
        if (!$data instanceof PaymentCheckoutDataInterface) {
            throw new LogicException(sprintf('%s needs to implement %s to check the eligibility of payment methods.', $data::class, PaymentCheckoutDataInterface::class));
        }

        // no need to iterate the payment methods when there is nothing to be paid
        if (($data->getQuote()->getTotalGross() - $data->getPayments()->getTotal($data->getCurrency())) <= 0) {
            return [];
        }

        return array_values(array_filter(
            $this->paymentMethods,
            static fn (PaymentMethodInterface $paymentMethod) => $paymentMethod->isEligible($data),
        ));
    }
}
