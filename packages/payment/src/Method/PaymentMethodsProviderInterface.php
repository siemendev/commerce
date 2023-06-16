<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Method;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;

interface PaymentMethodsProviderInterface
{
    /**
     * @return array<string, PaymentMethodInterface<PaymentInterface>> indexed by identifier
     */
    public function getEligiblePaymentMethods(CheckoutDataInterface $data): array;

    /**
     * @return PaymentMethodInterface<PaymentInterface>
     */
    public function getPaymentMethod(string $identifier): PaymentMethodInterface;
}
