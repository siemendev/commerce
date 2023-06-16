<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\SymfonyBridge;

use Siemendev\Checkout\Delivery\AdditionalCost\AdditionalCostProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class CheckoutDeliveryExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new CheckoutDeliveryConfiguration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(CheckoutDeliveryBundle::PARAMETER_CONFIG, $config);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../config'));
        $loader->load('services.yaml');

        if (class_exists(AdditionalCostProvider::class)) {
            $container->setDefinition(
                'checkout.additional_costs_provider.delivery',
                (new Definition(AdditionalCostProvider::class))->setAutoconfigured(true),
            );
        }
    }
}
