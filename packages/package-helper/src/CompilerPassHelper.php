<?php declare(strict_types=1);

namespace Siemendev\SymfonyPackageHelper;

use LogicException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CompilerPassHelper
{
    private ContainerBuilder $container;

    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    public function addChildServicesToParent(
        string $parentServiceId,
        array $childServiceIds,
        string $methodToCall,
        ?string $interfaceToImplement = null
    ): self {
        foreach ($childServiceIds as $childServiceId) {
            $this->addChildServiceToParent($parentServiceId, $childServiceId, $methodToCall, $interfaceToImplement);
        }

        return $this;
    }

    public function addChildServiceToParent(
        string $parentServiceId,
        string $childServiceId,
        string $methodToCall,
        ?string $interfaceToImplement = null
    ): self {
        $service = $this->container->getDefinition($childServiceId);

        if (null !== $interfaceToImplement && !is_a($service->getClass(), $interfaceToImplement, true)) {
            throw new LogicException(sprintf(
                '"%s" needs to implements "%s".',
                $childServiceId,
                $interfaceToImplement,
            ));
        }

        $this->container->getDefinition($parentServiceId)
            ->addMethodCall($methodToCall, [new Reference($childServiceId)])
        ;

        return $this;
    }

    public function addTaggedServicesToParent(
        string $parentServiceId,
        string $tag,
        string $methodToCall,
        ?string $interfaceToImplement = null
    ): self {
        $this->addChildServicesToParent(
            $parentServiceId,
            array_keys($this->container->findTaggedServiceIds($tag)),
            $methodToCall,
            $interfaceToImplement,
        );

        return $this;
    }
}
