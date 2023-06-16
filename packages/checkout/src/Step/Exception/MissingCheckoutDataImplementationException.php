<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Step\Exception;

use Siemendev\Checkout\Data\CheckoutDataInterface;

class MissingCheckoutDataImplementationException extends ValidationException
{
    /**
     * @param class-string<CheckoutDataInterface> $checkoutDataInterface
     * @param class-string<CheckoutDataInterface> $requiredInterface
     */
    public function __construct(string $checkoutDataInterface, string $requiredInterface, string $stepIdentifier)
    {
        parent::__construct(sprintf(
            'Your checkout data (%s) needs to implement "%s" for step "%s" to work!',
            $checkoutDataInterface,
            $requiredInterface,
            $stepIdentifier,
        ));
    }
}
