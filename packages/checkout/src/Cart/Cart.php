<?php declare(strict_types=1);

namespace Siemendev\Checkout\Cart;

use App\Commerce\Product;
use App\Commerce\Subscription;
use InvalidArgumentException;
use Siemendev\Checkout\Item\Product\ProductInterface;
use Siemendev\Checkout\Item\Subscription\SubscriptionInterface;

class Cart implements CartInterface
{
    /** @var array<Product> */
    private array $products = [];

    /** @var array<Subscription> */
    private array $subscriptions = [];

    /** @param array<Product> $products */
    public function setProducts(array $products): static
    {
        $this->products = [];

        foreach ($products as $product) {
            if (!$product instanceof ProductInterface) {
                throw new InvalidArgumentException(sprintf('Given product of type "%s" does not implement "%s".', $product::class, ProductInterface::class));
            }
            $this->addProduct($product);
        }

        return $this;
    }

    public function addProduct(Product $product): static
    {
        $this->products[] = $product;

        return $this;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    /** @param array<Subscription> $subscriptions */
    public function setSubscriptions(array $subscriptions): static
    {
        $this->subscriptions = [];

        foreach ($subscriptions as $subscription) {
            if (!$subscription instanceof SubscriptionInterface) {
                throw new InvalidArgumentException(sprintf('Given product of type "%s" does not implement "%s".', $subscription::class, SubscriptionInterface::class));
            }
            $this->addSubscription($subscription);
        }

        return $this;
    }

    public function addSubscription(Subscription $subscription): static
    {
        $this->subscriptions[] = $subscription;

        return $this;
    }

    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }

    public function getItems(): array
    {
        return array_merge(
            $this->getProducts(),
            $this->getSubscriptions(),
        );
    }

    public function isEmpty(): bool
    {
        return 0 === count($this->getItems());
    }
}
