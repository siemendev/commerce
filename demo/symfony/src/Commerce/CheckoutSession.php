<?php declare(strict_types=1);

namespace App\Commerce;

use App\Commerce\Step\AgeVerifiableCheckoutSession;
use App\Commerce\Step\AgeVerifiableCheckoutSessionInterface;
use Siemendev\Checkout\CheckoutSessionInterface;
use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutSession;
use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutSessionInterface;
use Siemendev\Checkout\Step\Address\Delivery\DeliveryAddressableCheckoutSession;
use Siemendev\Checkout\Step\Address\Delivery\DeliveryAddressableCheckoutSessionInterface;

class CheckoutSession implements CheckoutSessionInterface, DeliveryAddressableCheckoutSessionInterface, BillingAddressableCheckoutSessionInterface, AgeVerifiableCheckoutSessionInterface
{
    use DeliveryAddressableCheckoutSession;
    use BillingAddressableCheckoutSession;
    use AgeVerifiableCheckoutSession;

    /** @var array<Item> */
    private array $items = [];

    private string $currency;

    public function setItems(array $items): CheckoutSession
    {
        $this->items = $items;

        return $this;
    }

    public function addItem(Item $item): CheckoutSession
    {
        $this->items[] = $item;

        return $this;
    }

    public function setCurrency(string $currency): CheckoutSession
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
