<?php declare(strict_types=1);

namespace Siemendev\Checkout\SymfonyBridge;

use Siemendev\Checkout\Finalize\CheckoutFinalizationHandlerInterface;
use Siemendev\Checkout\Step\StepInterface;
use Siemendev\Checkout\SymfonyBridge\Data\CheckoutDataCreatorInterface;
use Siemendev\SymfonyPackageHelper\CompilerPassHelper;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CheckoutCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $config = $container->getParameter(CheckoutBundle::PARAMETER_CONFIG);

        (new CompilerPassHelper($container))
            ->addChildServicesToParent(
                CheckoutBundle::SERVICE_STEP_MACHINE,
                is_array($config) ? $config['steps'] ?? [] : [],
                'addAvailableStep',
                StepInterface::class,
            )
            ->addChildServiceToParent(
                CheckoutBundle::SERVICE_DATA_FACTORY,
                is_array($config) ? $config['data_creator'] ?? '' : '',
                'setDataCreator',
                CheckoutDataCreatorInterface::class,
            )
            ->addTaggedServicesToParent(
                CheckoutBundle::SERVICE_FINALIZER,
                CheckoutBundle::TAG_FINALIZATION_HANDLER,
                'addFinalizationHandler',
                CheckoutFinalizationHandlerInterface::class,
            )
        ;
    }
}
