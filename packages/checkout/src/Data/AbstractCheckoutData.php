<?php declare(strict_types=1);

namespace Siemendev\Checkout\Data;

use Siemendev\Checkout\Cart\Cart;
use Siemendev\Checkout\Cart\CartInterface;

abstract class AbstractCheckoutData implements CheckoutDataInterface
{
    private CartInterface $cart;

    public function __construct(?CartInterface $cart = null)
    {
        $this->cart = $cart ?? new Cart();
    }

    public function getCart(): CartInterface
    {
        return $this->cart;
    }

    public function setCart(CartInterface $cart): static
    {
        $this->cart = $cart;

        return $this;
    }
}
