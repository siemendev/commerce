<?php declare(strict_types=1);

namespace Siemendev\Checkout\SymfonyBridge;

use Siemendev\Checkout\Pricing\Product\Provider\ProductPriceProviderInterface;
use Siemendev\Checkout\Quote\Builder\QuoteBuilder;
use Siemendev\Checkout\Step\StepMachine;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CheckoutBundle extends Bundle
{
    public const PARAMETER_CONFIG = 'checkout_config';

    public const SERVICE_CHECKOUT = 'checkout';
    public const SERVICE_STEP_MACHINE = self::SERVICE_CHECKOUT . '.step_machine';
    public const SERVICE_QUOTE_BUILDER = self::SERVICE_CHECKOUT . '.quote_builder';
    public const SERVICE_ADDITIONAL_COSTS_QUOTE_PART_BUILDER = self::SERVICE_CHECKOUT . '.quote_builder.part.additional_costs';
    public const SERVICE_PRICE_RESOLVER = self::SERVICE_CHECKOUT . '.price_resolver';
    public const SERVICE_AVAILABILITY_RESOLVER = self::SERVICE_CHECKOUT . '.availability_resolver';
    public const SERVICE_DATA_FACTORY = self::SERVICE_CHECKOUT . '.data_manager';

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CheckoutCompilerPass());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CheckoutExtension();
    }
}
