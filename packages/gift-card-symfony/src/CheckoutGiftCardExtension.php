<?php

declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\SymfonyBridge;

use Siemendev\Checkout\GiftCard\Checker\GiftCardCheckerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class CheckoutGiftCardExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new CheckoutGiftCardConfiguration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(CheckoutGiftCardBundle::PARAMETER_CONFIG, $config);

        $container->registerForAutoconfiguration(GiftCardCheckerInterface::class)
            ->addTag(CheckoutGiftCardBundle::TAG_GIFT_CARD_CHECKER)
        ;

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../config'));
        $loader->load('services.yaml');
    }
}
