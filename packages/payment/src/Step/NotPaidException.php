<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Step;

use Siemendev\Checkout\Step\Exception\ValidationException;

class NotPaidException extends ValidationException
{
    public function __construct()
    {
        parent::__construct('Order has not been paid yet.');
    }
}
