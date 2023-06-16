<?php

declare(strict_types=1);

namespace App\Commerce\Data;

use App\Commerce\Step\HasAgeVerification;
use Siemendev\Checkout\Data\AbstractCheckoutData;
use Siemendev\Checkout\Delivery\Data\IsDeliverable;
use Siemendev\Checkout\Payment\Data\ContainsPayments;
use Siemendev\Checkout\Payment\Payment\PaymentInterface;
use Siemendev\Checkout\Products\Data\ContainsProducts;
use Siemendev\Checkout\Products\Data\ContainsQuote;
use Siemendev\Checkout\Products\Product\ProductInterface;
use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutData;

class CheckoutData extends AbstractCheckoutData implements CheckoutDataInterface
{
    use BillingAddressableCheckoutData;
    use IsDeliverable;
    use HasAgeVerification;
    use ContainsProducts;
    use ContainsQuote;
    use ContainsPayments;

    private string $identifier;

    public function setIdentifier(string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getHash(): string
    {
        return md5(
            $this->getCurrency()
            . $this->getBillingAddress()?->getHash()
            . $this->getDeliveryAddress()?->getHash()
            . implode('-', array_map(static fn (ProductInterface $product) => $product->getIdentifier(), $this->getProducts()))
            . implode('-', array_map(static fn (PaymentInterface $payment) => $payment->getIdentifier() . $payment->getCurrency() . $payment->getAuthorizedAmount() . $payment->getCapturedAmount(), iterator_to_array($this->getPayments())))
            . $this->isAgeVerified()
            . $this->getDeliveryOption()?->getIdentifier(),
        );
    }
}
