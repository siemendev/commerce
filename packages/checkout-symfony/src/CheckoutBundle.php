<?php declare(strict_types=1);

namespace Siemendev\Checkout\SymfonyBridge;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CheckoutBundle extends Bundle
{
    public const PARAMETER_CONFIG = '.checkout';

    public const SERVICE_CHECKOUT = 'checkout';
    public const SERVICE_STEP_MACHINE = self::SERVICE_CHECKOUT . '.step_machine';
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
