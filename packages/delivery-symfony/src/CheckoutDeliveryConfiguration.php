<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\SymfonyBridge;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class CheckoutDeliveryConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('checkout_delivery');
        if ($treeBuilder->getRootNode() instanceof ArrayNodeDefinition) {
            $treeBuilder->getRootNode()->children()->arrayNode('options')->scalarPrototype();
        }

        return $treeBuilder;
    }
}
