<?php

declare(strict_types=1);

namespace Siemendev\Checkout\SymfonyBridge\Data;

use Siemendev\Checkout\Data\CheckoutDataInterface;

interface CheckoutDataCreatorInterface
{
    public function createEmptyCheckoutData(): CheckoutDataInterface;
}
