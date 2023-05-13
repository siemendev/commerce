<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Delivery\Exception;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\Exception\ValidationException;

class DeliveryTypeNotSetException extends ValidationException
{
    public function __construct(public readonly CheckoutDataInterface $data)
    {
        parent::__construct('Delivery type is not set in the checkout data.');
    }
}
