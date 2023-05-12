<?php declare(strict_types=1);

namespace App\Commerce;

use App\Commerce\Step\AgeVerifiableCheckoutSession;
use App\Commerce\Step\AgeVerifiableCheckoutSessionInterface;
use InvalidArgumentException;
use Siemendev\Checkout\CheckoutSessionInterface;
use Siemendev\Checkout\Item\Product\ProductInterface;
use Siemendev\Checkout\Item\Subscription\SubscriptionInterface;
use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutSession;
use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutSessionInterface;
use Siemendev\Checkout\Step\Address\Delivery\DeliveryAddressableCheckoutSession;
use Siemendev\Checkout\Step\Address\Delivery\DeliveryAddressableCheckoutSessionInterface;

class CheckoutSession implements CheckoutSessionInterface, DeliveryAddressableCheckoutSessionInterface, BillingAddressableCheckoutSessionInterface, AgeVerifiableCheckoutSessionInterface
{
    use DeliveryAddressableCheckoutSession;
    use BillingAddressableCheckoutSession;
    use AgeVerifiableCheckoutSession;

    /** @var array<Product> */
    private array $products = [];

    /** @var array<Subscription> */
    private array $subscriptions = [];

    /** @param array<Product> $products */
    public function setProducts(array $products): CheckoutSession
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

    public function addProduct(Product $product): CheckoutSession
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
}
