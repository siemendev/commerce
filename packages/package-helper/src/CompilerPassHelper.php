<?php

declare(strict_types=1);

namespace Siemendev\SymfonyPackageHelper;

use LogicException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Reference;

class CompilerPassHelper
{
    private ContainerBuilder $container;

    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    /**
     * @param array<string> $childServiceIds array of service ids that should be added to the parent service
     */
    public function addChildServicesToParent(
        string $parentServiceId,
        array $childServiceIds,
        string $methodToCall,
        ?string $interfaceToImplement = null,
    ): self {
        foreach ($childServiceIds as $childServiceId) {
            $this->addChildServiceToParent($parentServiceId, $childServiceId, $methodToCall, $interfaceToImplement);
        }

        return $this;
    }

    /**
     * @throws ServiceNotFoundException when the child service id is not found
     * @throws LogicException when the child service does not implement the given interface
     */
    public function addChildServiceToParent(
        string $parentServiceId,
        string $childServiceId,
        string $methodToCall,
        ?string $interfaceToImplement = null,
    ): self {
        $class = $this->container->getDefinition($childServiceId)->getClass();

        if (null !== $interfaceToImplement) {
            if (null === $class || !class_exists($class)) {
                throw new LogicException(sprintf('Service "%s" needs to have a valid class name configured to verify it implements interface "%s".', $childServiceId, $interfaceToImplement));
            }
            if (!is_a($class, $interfaceToImplement, true)) {
                throw new LogicException(sprintf('Service "%s" needs to implements "%s" to be automatically added to service "%s".', $childServiceId, $interfaceToImplement, $parentServiceId));
            }
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
        ?string $interfaceToImplement = null,
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
