<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Payment\SymfonyBridge;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CheckoutPaymentBundle extends Bundle
{
    public const TAG_PAYMENT_METHOD = 'checkout.payment_method';

    public const SERVICE_PAYMENT_METHOD_PROVIDER = 'checkout.payment.methods_provider';

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CheckoutPaymentCompilerPass());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CheckoutPaymentExtension();
    }
}
