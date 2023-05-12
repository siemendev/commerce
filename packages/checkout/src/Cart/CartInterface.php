<?php declare(strict_types=1);

namespace Siemendev\Checkout\Cart;

use Siemendev\Checkout\Item\ItemInterface;
use Siemendev\Checkout\Item\Product\ProductInterface;
use Siemendev\Checkout\Item\Subscription\SubscriptionInterface;

interface CartInterface
{
    /**
     * @return array<ProductInterface>
     */
    public function getProducts(): array;

    /**
     * @return array<SubscriptionInterface>
     */
    public function getSubscriptions(): array;

    /**
     * @return array<ItemInterface>
     */
    public function getItems(): array;

    public function isEmpty(): bool;
}
