<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote;

use Siemendev\Checkout\Quote\Action\QuoteActionInterface;
use Siemendev\Checkout\Quote\Product\ProductQuoteInterface;
use Siemendev\Checkout\Quote\Subscription\SubscriptionQuoteInterface;

class Quote implements QuoteInterface
{
    /** @var array<ProductQuoteInterface> */
    private array $products = [];

    /** @var array<SubscriptionQuoteInterface> */
    private array $subscriptions = [];

    /** @var array<QuoteActionInterface> */
    private array $actions = [];

    public function getProducts(): array
    {
        return $this->products;
    }

    public function addProduct(ProductQuoteInterface $product): static
    {
        $this->products[] = $product;

        return $this;
    }

    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }

    public function addSubscription(SubscriptionQuoteInterface $subscription): static
    {
        $this->subscriptions[] = $subscription;

        return $this;
    }

    public function getActions(): array
    {
        return $this->actions;
    }

    public function addAction(QuoteActionInterface $action): static
    {
        $this->actions[] = $action;

        return $this;
    }
}
