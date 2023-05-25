<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\SymfonyBridge;

use Siemendev\Checkout\Products\AdditionalCost\AdditionalCostProviderInterface;
use Siemendev\Checkout\Products\Availability\Provider\AvailabilityProviderInterface;
use Siemendev\Checkout\Products\Pricing\Provider\PriceProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class CheckoutProductsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(PriceProviderInterface::class)
            ->addTag(CheckoutProductsBundle::TAG_PRICE_PROVIDER)
        ;
        $container->registerForAutoconfiguration(AvailabilityProviderInterface::class)
            ->addTag(CheckoutProductsBundle::TAG_AVAILABILITY_PROVIDER)
        ;
        $container->registerForAutoconfiguration(AdditionalCostProviderInterface::class)
            ->addTag(CheckoutProductsBundle::TAG_ADDITIONAL_COSTS_PROVIDER)
        ;

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../config'));
        $loader->load('services.yaml');
    }
}
