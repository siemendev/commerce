<?php declare(strict_types=1);

namespace Siemendev\Checkout\Pricing;

use LogicException;
use Siemendev\Checkout\Item\ItemInterface;
use Siemendev\Checkout\Pricing\Product\Provider\ProductPriceProviderInterface;
use Siemendev\Checkout\Pricing\Subscription\Provider\SubscriptionPriceProviderInterface;

class PriceProviderNotFoundException extends LogicException
{
    /**
     * @param array<ProductPriceProviderInterface|SubscriptionPriceProviderInterface> $providers
     */
    public function __construct(
        public ItemInterface $item,
        public array $providers,
    ) {
        parent::__construct('could not find matching price provider for item');
    }
}
