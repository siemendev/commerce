<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Products\Pricing;

use LogicException;
use Siemendev\Checkout\Products\Pricing\Provider\PriceProviderInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;

class PriceProviderNotFoundException extends LogicException
{
    /**
     * @param array<PriceProviderInterface> $providers
     */
    public function __construct(
        public ProductInterface $product,
        public array $providers,
    ) {
        parent::__construct('could not find matching price provider for item');
    }
}
