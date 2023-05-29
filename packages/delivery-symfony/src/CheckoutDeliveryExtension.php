<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\SymfonyBridge;

use Siemendev\Checkout\Products\AdditionalCost\AdditionalCostProviderInterface;
use Siemendev\Checkout\Products\Availability\Provider\AvailabilityProviderInterface;
use Siemendev\Checkout\Products\Pricing\Provider\PriceProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class CheckoutDeliveryExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../config'));
        $loader->load('services.yaml');
    }
}
