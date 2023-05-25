<?php declare(strict_types=1);

namespace Siemendev\Checkout\SymfonyBridge;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class CheckoutConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('checkout');

        $treeBuilder->getRootNode()->children()->scalarNode('data_creator');
        $treeBuilder->getRootNode()->children()->arrayNode('steps')->scalarPrototype();

        return $treeBuilder;
    }
}
