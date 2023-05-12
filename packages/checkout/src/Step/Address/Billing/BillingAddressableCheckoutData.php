<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address\Billing;

use Siemendev\Checkout\Step\Address\AddressInterface;

trait BillingAddressableCheckoutData
{
    private ?AddressInterface $billingAddress = null;

    public function setBillingAddress(?AddressInterface $billingAddress): static
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getBillingAddress(): ?AddressInterface
    {
        return $this->billingAddress;
    }
}
