<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\Step;

use Siemendev\Checkout\Step\Exception\ValidationException;

class DeliveryAddressNotSetException extends ValidationException
{
    public function __construct()
    {
        parent::__construct('Delivery address is not set in the checkout data.');
    }
}
