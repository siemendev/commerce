<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\SymfonyBridge;

use Siemendev\Checkout\Payment\Method\PaymentMethodInterface;
use Siemendev\SymfonyPackageHelper\CompilerPassHelper;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CheckoutPaymentCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        (new CompilerPassHelper($container))
            ->addTaggedServicesToParent(
                CheckoutPaymentBundle::SERVICE_PAYMENT_METHOD_PROVIDER,
                CheckoutPaymentBundle::TAG_PAYMENT_METHOD,
                'addPaymentMethod',
                PaymentMethodInterface::class,
            )
        ;
    }
}
