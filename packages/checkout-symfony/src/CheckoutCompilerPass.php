<?php declare(strict_types=1);

namespace Siemendev\Checkout\SymfonyBridge;

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
                $config['steps'],
                'addAvailableStep',
                StepInterface::class,
            )
            ->addChildServiceToParent(
                CheckoutBundle::SERVICE_DATA_FACTORY,
                $config['data_creator'],
                'setDataCreator',
                CheckoutDataCreatorInterface::class,
            )
        ;
    }
}
