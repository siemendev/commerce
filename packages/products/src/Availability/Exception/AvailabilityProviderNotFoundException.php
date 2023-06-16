<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Products\Availability\Exception;

use LogicException;
use Siemendev\Checkout\Products\Availability\Provider\AvailabilityProviderInterface;
use Siemendev\Checkout\Products\Product\ProductInterface;

class AvailabilityProviderNotFoundException extends LogicException
{
    /**
     * @param array<AvailabilityProviderInterface> $availableProviders
     */
    public function __construct(
        public ProductInterface $product,
        public array $availableProviders,
    ) {
        parent::__construct('could not find availability provider for product');
    }
}
