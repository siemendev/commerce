<?php declare(strict_types=1);

namespace Siemendev\Checkout\Data;

/**
 * This interface is only used to identify a class as checkout data.
 */
interface CheckoutDataInterface
{
    public function getCurrency(): string;

    public function isLocked(): bool;

    public function lock(): void;
}
