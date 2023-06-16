<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Method;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Payment\Data\PaymentCheckoutDataInterface;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;

class PaymentMethodsProvider implements PaymentMethodsProviderInterface
{
    /**
     * @param array<PaymentMethodInterface<PaymentInterface>> $paymentMethods
     */
    public function __construct(
        private array $paymentMethods = [],
    ) {
    }

    /**
     * @param array<PaymentMethodInterface<PaymentInterface>> $paymentMethods
     */
    public function setPaymentMethods(array $paymentMethods): void
    {
        $this->paymentMethods = $paymentMethods;
    }

    /**
     * @param PaymentMethodInterface<PaymentInterface> $paymentMethod
     */
    public function addPaymentMethod(PaymentMethodInterface $paymentMethod): static
    {
        $this->paymentMethods[] = $paymentMethod;

        return $this;
    }

    public function getEligiblePaymentMethods(CheckoutDataInterface $data): array
    {
        if (!$data instanceof PaymentCheckoutDataInterface) {
            throw new LogicException(sprintf('%s needs to implement %s to check the eligibility of payment methods.', $data::class, PaymentCheckoutDataInterface::class));
        }

        // no need to iterate the payment methods when there is nothing to be paid
        if ($data->getOpenTotal() <= 0) {
            return [];
        }

        $paymentMethods = [];
        foreach ($this->paymentMethods as $paymentMethod) {
            if (!$paymentMethod->isEligible($data)) {
                continue;
            }
            $paymentMethods[$paymentMethod->getIdentifier()] = $paymentMethod;
        }

        return $paymentMethods;
    }

    public function getPaymentMethod(string $identifier): PaymentMethodInterface
    {
        foreach ($this->paymentMethods as $paymentMethod) {
            if ($paymentMethod->getIdentifier() === $identifier) {
                return $paymentMethod;
            }
        }

        throw new LogicException(sprintf('Payment method with identifier "%s" not found.', $identifier));
    }
}
