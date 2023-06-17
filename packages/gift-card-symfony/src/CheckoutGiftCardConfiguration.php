<?php

declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\SymfonyBridge;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class CheckoutGiftCardConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('checkout_gift_card');
        if ($treeBuilder->getRootNode() instanceof ArrayNodeDefinition) {
            $treeBuilder->getRootNode()->children()->scalarNode('capturing_manager');
        }

        return $treeBuilder;
    }
}
