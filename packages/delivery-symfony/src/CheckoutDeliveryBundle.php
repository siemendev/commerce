<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\SymfonyBridge;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CheckoutDeliveryBundle extends Bundle
{
    public const SERVICE_DELIVERY_OPTIONS_RESOLVER = 'checkout.delivery.options_resolver';
    public const PARAMETER_CONFIG = 'checkout_delivery';

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CheckoutDeliveryCompilerPass());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CheckoutDeliveryExtension();
    }
}
