<?php declare(strict_types=1);

namespace Siemendev\Checkout\Availability;

use Exception;
use LogicException;
use Siemendev\Checkout\Item\ItemInterface;

class AvailabilityProviderNotFoundException extends LogicException
{
    public function __construct(
        public ItemInterface $item,
        public array $availableProviders,
    ) {
        parent::__construct('could not find availability provider for item');
    }
}
