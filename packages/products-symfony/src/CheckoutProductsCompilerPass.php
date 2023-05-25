<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\SymfonyBridge;

use LogicException;
use Siemendev\Checkout\Products\Availability\Provider\AvailabilityProviderInterface;
use Siemendev\Checkout\Products\Pricing\Provider\PriceProviderInterface;
use Siemendev\Checkout\SymfonyBridge\CheckoutBundle;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CheckoutProductsCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $container->getDefinition(CheckoutBundle::SERVICE_STEP_MACHINE)->addMethodCall(
            'addStepVoter', [new Reference(CheckoutProductsBundle::SERVICE_STEP_VOTER)]
        );

        $this->addTaggedServices(
            $container,
            CheckoutProductsBundle::TAG_PRICE_PROVIDER,
            CheckoutProductsBundle::SERVICE_PRICE_RESOLVER,
            'addProvider',
        );
        $this->addTaggedServices(
            $container,
            CheckoutProductsBundle::TAG_AVAILABILITY_PROVIDER,
            CheckoutProductsBundle::SERVICE_AVAILABILITY_RESOLVER,
            'addAvailabilityProvider',
        );
        $this->addTaggedServices(
            $container,
            CheckoutProductsBundle::TAG_ADDITIONAL_COSTS_PROVIDER,
            CheckoutProductsBundle::SERVICE_ADDITIONAL_COSTS_AGGREGATOR,
            'addProvider',
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
