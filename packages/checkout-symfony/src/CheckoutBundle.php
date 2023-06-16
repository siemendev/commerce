<?php

declare(strict_types=1);

namespace Siemendev\Checkout\SymfonyBridge;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CheckoutBundle extends Bundle
{
    public const PARAMETER_CONFIG = '.checkout';

    public const SERVICE_CHECKOUT = 'checkout';

    public const SERVICE_STEP_MACHINE = 'checkout.step_machine';

    public const SERVICE_DATA_FACTORY = 'checkout.data_manager';

    public const SERVICE_FINALIZER = 'checkout.finalizer';

    public const TAG_FINALIZATION_HANDLER = 'checkout.finalization_handler';

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CheckoutCompilerPass());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CheckoutExtension();
    }
}
