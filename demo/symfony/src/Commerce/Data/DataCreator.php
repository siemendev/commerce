<?php

declare(strict_types=1);

namespace App\Commerce\Data;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\Address\Address;
use Siemendev\Checkout\SymfonyBridge\Data\CheckoutDataCreatorInterface;

/**
 * @implements CheckoutDataCreatorInterface<CheckoutData>
 */
class DataCreator implements CheckoutDataCreatorInterface
{
    public function createEmptyCheckoutData(): CheckoutDataInterface
    {
        return (new CheckoutData())
            ->setIdentifier((string) rand(1, PHP_INT_MAX))
            ->setBillingAddress(
                (new Address())
                    ->setCountryCode('FR'), // todo load locale from request
            )
            ->setCurrency('EUR')
        ;
    }
}
