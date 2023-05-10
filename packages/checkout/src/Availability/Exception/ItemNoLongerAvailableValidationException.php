<?php declare(strict_types=1);

namespace Siemendev\Checkout\Availability\Exception;

use Siemendev\Checkout\Item\ItemInterface;
use Siemendev\Checkout\Step\Exception\ValidationException;

class ItemNoLongerAvailableValidationException extends ValidationException
{
    public function __construct(public readonly ItemInterface $item)
    {
        parent::__construct('Item is no longer available in requested quantity.');
    }
}
