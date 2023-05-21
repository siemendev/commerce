<?php declare(strict_types=1);

namespace App\Commerce;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\Address\Address;
use Siemendev\Checkout\SymfonyBridge\Data\CheckoutDataCreatorInterface;

class DataCreator implements CheckoutDataCreatorInterface
{
    public function createEmptyCheckoutData(): CheckoutDataInterface
    {
        return (new CheckoutData())
            ->setBillingAddress(
                (new Address())
                    ->setCountryCode('FR') // todo load locale from request
            )
        ;
    }
}
