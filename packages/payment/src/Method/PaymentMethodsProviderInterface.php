<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Method;

use Siemendev\Checkout\Data\CheckoutDataInterface;

interface PaymentMethodsProviderInterface
{
    /**
     * @return array<string, PaymentMethodInterface> indexed by identifier
     */
    public function getEligiblePaymentMethods(CheckoutDataInterface $data): array;

    public function getPaymentMethod(string $identifier): PaymentMethodInterface;
}
