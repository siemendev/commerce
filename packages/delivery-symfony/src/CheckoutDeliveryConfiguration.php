<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\SymfonyBridge;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class CheckoutDeliveryConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('checkout_delivery');
        $treeBuilder->getRootNode()->children()->arrayNode('options')->scalarPrototype();

        return $treeBuilder;
    }
}
