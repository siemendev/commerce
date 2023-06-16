<?php

declare(strict_types=1);

namespace Siemendev\Checkout\SymfonyBridge;

use Siemendev\Checkout\Finalize\CheckoutFinalizationHandlerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class CheckoutExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new CheckoutConfiguration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(CheckoutBundle::PARAMETER_CONFIG, $config);

        $container->registerForAutoconfiguration(CheckoutFinalizationHandlerInterface::class)
            ->addTag(CheckoutBundle::TAG_FINALIZATION_HANDLER)
        ;

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../config'));
        $loader->load('services.yaml');
    }
}
