<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\SymfonyBridge;

use LogicException;
use Siemendev\Checkout\SymfonyBridge\Data\CheckoutDataCreatorInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CheckoutDeliveryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $config = $container->getParameter(CheckoutDeliveryBundle::PARAMETER_CONFIG);

        $this->wireConfiguredServices(
            CheckoutDeliveryBundle::SERVICE_DELIVERY_OPTIONS_RESOLVER,
            $config['options'],
            $container,
            'addOption',
        );
    }

    private function wireConfiguredServices(
        string $parentServiceId,
        array $childServiceIds,
        ContainerBuilder $container,
        string $methodToCall,
    ): void {
        foreach ($childServiceIds as $childServiceId) {
            if (!$container->hasDefinition($childServiceId)) {
                throw new LogicException(sprintf('Service with ID "%s" does not exist.', $childServiceId));
            }

            $container->getDefinition($parentServiceId)
                ->addMethodCall($methodToCall, [new Reference($childServiceId)])
            ;
        }
    }
}
