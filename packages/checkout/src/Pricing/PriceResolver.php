<?php declare(strict_types=1);

namespace Siemendev\Checkout\Pricing;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Item\Product\ProductInterface;
use Siemendev\Checkout\Item\Subscription\SubscriptionInterface;
use Siemendev\Checkout\Pricing\Product\ProductPriceInterface;
use Siemendev\Checkout\Pricing\Product\Provider\ProductPriceProviderInterface;
use Siemendev\Checkout\Pricing\Subscription\SubscriptionPriceInterface;
use Siemendev\Checkout\Pricing\Subscription\Provider\SubscriptionPriceProviderInterface;

class PriceResolver implements PriceResolverInterface
{
    /**
     * @param array<ProductPriceProviderInterface> $productPriceProviders
     * @param array<SubscriptionPriceProviderInterface> $subscriptionPriceProviders
     */
    public function __construct(
        private array $productPriceProviders = [],
        private array $subscriptionPriceProviders = [],
    ) {
    }

    /**
     * @param array<ProductPriceProviderInterface> $productPriceProviders
     */
    public function setProductPriceProviders(array $productPriceProviders): static
    {
        $this->productPriceProviders = $productPriceProviders;

        return $this;
    }

    public function addProductPriceProvider(ProductPriceProviderInterface $provider): static
    {
        $this->productPriceProviders[] = $provider;

        return $this;
    }

    /**
     * @param array<SubscriptionPriceProviderInterface> $subscriptionPriceProviders
     */
    public function setSubscriptionPriceProviders(array $subscriptionPriceProviders): static
    {
        $this->subscriptionPriceProviders = $subscriptionPriceProviders;

        return $this;
    }

    public function addSubscriptionPriceProvider(SubscriptionPriceProviderInterface $provider): static
    {
        $this->subscriptionPriceProviders[] = $provider;

        return $this;
    }

    public function getProductPrice(ProductInterface $product, CheckoutDataInterface $data): ProductPriceInterface
    {
        foreach ($this->productPriceProviders as $priceProvider) {
            if ($priceProvider->eligible($product)) {
                return $priceProvider->getProductPrice($product, $data);
            }
        }

        throw new PriceProviderNotFoundException($product, $this->productPriceProviders);
    }

    public function getSubscriptionPrice(SubscriptionInterface $subscription): SubscriptionPriceInterface
    {
        foreach ($this->subscriptionPriceProviders as $priceProvider) {
            if ($priceProvider->eligible($subscription)) {
                return $priceProvider->getSubscriptionPrice($subscription);
            }
        }

        throw new PriceProviderNotFoundException($subscription, $this->subscriptionPriceProviders);
    }
}
