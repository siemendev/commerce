<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\SymfonyBridge;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CheckoutPaymentCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $this->addTaggedServices(
            $container,
            CheckoutPaymentBundle::TAG_PAYMENT_METHOD,
            CheckoutPaymentBundle::SERVICE_PAYMENT_METHOD_PROVIDER,
            'addPaymentMethod',
        );
    }

    private function addTaggedServices(ContainerBuilder $container, string $tag, string $serviceId, string $method): void
    {
        $definition = $container->findDefinition($serviceId);

        foreach ($container->findTaggedServiceIds($tag) as $childId => $tags) {
            $definition->addMethodCall($method, [new Reference($childId)]);
        }
    }
}
