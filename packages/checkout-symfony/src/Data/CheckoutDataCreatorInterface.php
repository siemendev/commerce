<?php

declare(strict_types=1);

namespace Siemendev\Checkout\SymfonyBridge\Data;

use Siemendev\Checkout\Data\CheckoutDataInterface;

/**
 * @template T of CheckoutDataInterface
 */
interface CheckoutDataCreatorInterface
{
    /**
     * @return T
     */
    public function createEmptyCheckoutData(): CheckoutDataInterface;
}
