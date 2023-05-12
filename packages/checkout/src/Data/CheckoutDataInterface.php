<?php declare(strict_types=1);

namespace Siemendev\Checkout\Data;

use Siemendev\Checkout\Cart\CartInterface;

interface CheckoutDataInterface
{
    public function getCart(): CartInterface;
}
