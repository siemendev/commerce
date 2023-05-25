<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Step;

use Siemendev\Checkout\Step\Exception\ValidationException;

class EmptyCartValidationException extends ValidationException
{
    public function __construct()
    {
        parent::__construct('Cart is empty');
    }
}
