<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address\Billing;

use Siemendev\Checkout\Step\Exception\ValidationException;

class BillingAddressNotSetException extends ValidationException
{
    public function __construct()
    {
        parent::__construct('Billing address is not set in the checkout data.');
    }
}
