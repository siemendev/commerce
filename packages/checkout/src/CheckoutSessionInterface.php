<?php declare(strict_types=1);

namespace Siemendev\Checkout;

use Siemendev\Checkout\Item\Product\ProductInterface;
use Siemendev\Checkout\Item\Subscription\SubscriptionInterface;

interface CheckoutSessionInterface
{
    /**
     * Get the products of the current checkout session.
     *
     * @return array<ProductInterface>
     */
    public function getProducts(): array;

    /**
     * Get the subscriptions of the current checkout session.
     *
     * @return array<SubscriptionInterface>
     */
    public function getSubscriptions(): array;
}
