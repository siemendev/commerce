<?php declare(strict_types=1);

namespace Siemendev\Checkout\SymfonyBridge;

use LogicException;
use Siemendev\Checkout\SymfonyBridge\Data\CheckoutDataCreatorInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CheckoutCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $config = $container->getParameter(CheckoutBundle::PARAMETER_CONFIG);

        $this->wireConfiguredServices(
            CheckoutBundle::SERVICE_STEP_MACHINE,
            $config['steps'],
            $container,
            'addStep',
        );
        $this->wireConfiguredServices(
            CheckoutBundle::SERVICE_QUOTE_BUILDER,
            $config['quote_builders'],
            $container,
            'addQuotePartBuilder',
        );
        $this->wireConfiguredServices(
            CheckoutBundle::SERVICE_PRICE_RESOLVER,
            $config['product_price_providers'],
            $container,
            'addProductPriceProvider',
        );
        $this->wireConfiguredServices(
            CheckoutBundle::SERVICE_PRICE_RESOLVER,
            $config['subscription_price_providers'],
            $container,
            'addSubscriptionPriceProvider',
        );
        $this->wireConfiguredServices(
            CheckoutBundle::SERVICE_AVAILABILITY_RESOLVER,
            $config['availability_providers'],
            $container,
            'addAvailabilityProvider',
        );
        $this->wireConfiguredServices(
            CheckoutBundle::SERVICE_ADDITIONAL_COSTS_QUOTE_PART_BUILDER,
            $config['additional_cost_providers'],
            $container,
            'addAdditionalCostProvider',
        );

        if (!class_exists($config['data_creator'])
            || !is_a($config['data_creator'], CheckoutDataCreatorInterface::class, true)
        ) {
            throw new LogicException(sprintf(
                '"%s" needs to be a valid class that implements "%s".',
                $config['data_creator'],
                CheckoutDataCreatorInterface::class,
            ));
        }
        $container->getDefinition(CheckoutBundle::SERVICE_DATA_FACTORY)
            ->addMethodCall('setDataCreator', [new Reference($config['data_creator'])])
        ;
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
