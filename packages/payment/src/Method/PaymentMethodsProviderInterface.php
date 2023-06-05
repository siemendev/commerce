<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Method;

use Siemendev\Checkout\Data\CheckoutDataInterface;

interface PaymentMethodsProviderInterface
{
    public function getEligiblePaymentMethods(CheckoutDataInterface $data): array;
}
