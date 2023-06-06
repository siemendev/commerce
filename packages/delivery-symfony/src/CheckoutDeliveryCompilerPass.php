<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\SymfonyBridge;

use Siemendev\Checkout\Delivery\Option\DeliveryOptionInterface;
use Siemendev\SymfonyPackageHelper\CompilerPassHelper;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CheckoutDeliveryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $config = $container->getParameter(CheckoutDeliveryBundle::PARAMETER_CONFIG);

        (new CompilerPassHelper($container))
            ->addChildServicesToParent(
                CheckoutDeliveryBundle::SERVICE_DELIVERY_OPTIONS_RESOLVER,
                $config['options'],
                'addOption',
                DeliveryOptionInterface::class,
            )
        ;
    }
}
