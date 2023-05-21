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
        $treeBuilder->getRootNode()->children()->arrayNode('quote_builders')->scalarPrototype();
        $treeBuilder->getRootNode()->children()->arrayNode('product_price_providers')->scalarPrototype();
        $treeBuilder->getRootNode()->children()->arrayNode('subscription_price_providers')->scalarPrototype();
        $treeBuilder->getRootNode()->children()->arrayNode('availability_providers')->scalarPrototype();
        $treeBuilder->getRootNode()->children()->arrayNode('additional_cost_providers')->scalarPrototype();

        return $treeBuilder;
    }
}
