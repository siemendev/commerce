<?php declare(strict_types=1);

namespace Siemendev\Checkout\Pricing;

use Exception;
use LogicException;
use Siemendev\Checkout\Item\ItemInterface;

class PriceProviderNotFoundException extends LogicException
{
    public function __construct(
        public ItemInterface $item,
        public string $currency,
        public array $providers,
    ) {
        parent::__construct('could not find price provider for item');
    }
}
