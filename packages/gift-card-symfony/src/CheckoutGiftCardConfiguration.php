<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\SymfonyBridge;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class CheckoutGiftCardConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('checkout_gift_card');
        $treeBuilder->getRootNode()->children()->scalarNode('repository');

        return $treeBuilder;
    }
}
