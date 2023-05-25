<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\SymfonyBridge;

use Siemendev\Checkout\SymfonyBridge\CheckoutBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CheckoutProductsBundle extends Bundle
{
    public const TAG_PRICE_PROVIDER = CheckoutBundle::SERVICE_CHECKOUT . '.product_price_provider';
    public const TAG_AVAILABILITY_PROVIDER = CheckoutBundle::SERVICE_CHECKOUT . '.product_availability_provider';
    public const TAG_ADDITIONAL_COSTS_PROVIDER = CheckoutBundle::SERVICE_CHECKOUT . '.additional_costs_provider';

    public const SERVICE_STEP_VOTER = CheckoutBundle::SERVICE_CHECKOUT . '.step_voters.products';
    public const SERVICE_PRICE_RESOLVER = CheckoutBundle::SERVICE_CHECKOUT . '.product_price_resolver';
    public const SERVICE_AVAILABILITY_RESOLVER = CheckoutBundle::SERVICE_CHECKOUT . '.product_availability_resolver';
    public const SERVICE_ADDITIONAL_COSTS_AGGREGATOR = CheckoutBundle::SERVICE_CHECKOUT . '.additional_costs_aggregator';

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CheckoutProductsCompilerPass());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CheckoutProductsExtension();
    }
}
