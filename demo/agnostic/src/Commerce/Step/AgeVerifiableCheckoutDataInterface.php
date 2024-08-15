<?php

declare(strict_types=1);

namespace Demo\Commerce\Step;

use Siemendev\Checkout\Data\CheckoutDataInterface;

interface AgeVerifiableCheckoutDataInterface extends CheckoutDataInterface
{
    public function isAgeVerified(): bool;
}
