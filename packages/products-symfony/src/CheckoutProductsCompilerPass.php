<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\SymfonyBridge;

use Siemendev\Checkout\Products\AdditionalCost\AdditionalCostProviderInterface;
use Siemendev\Checkout\Products\Availability\Provider\AvailabilityProviderInterface;
use Siemendev\Checkout\Products\Pricing\Provider\PriceProviderInterface;
use Siemendev\Checkout\SymfonyBridge\CheckoutBundle;
use Siemendev\SymfonyPackageHelper\CompilerPassHelper;
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

        (new CompilerPassHelper($container))
            ->addTaggedServicesToParent(
                CheckoutProductsBundle::SERVICE_PRICE_RESOLVER,
                CheckoutProductsBundle::TAG_PRICE_PROVIDER,
                'addProvider',
                PriceProviderInterface::class,
            )
            ->addTaggedServicesToParent(
                CheckoutProductsBundle::SERVICE_AVAILABILITY_RESOLVER,
                CheckoutProductsBundle::TAG_AVAILABILITY_PROVIDER,
                'addAvailabilityProvider',
                AvailabilityProviderInterface::class,
            )
            ->addTaggedServicesToParent(
                CheckoutProductsBundle::SERVICE_ADDITIONAL_COSTS_AGGREGATOR,
                CheckoutProductsBundle::TAG_ADDITIONAL_COSTS_PROVIDER,
                'addProvider',
                AdditionalCostProviderInterface::class,
            )
        ;
    }
}
