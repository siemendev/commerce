<?php

declare(strict_types=1);

namespace Demo\Commerce\Data;

use Demo\Commerce\Step\HasAgeVerificationImmutable;
use Siemendev\Checkout\Data\AbstractCheckoutDataImmutable;
use Siemendev\Checkout\Delivery\Data\IsDeliverableImmutable;
use Siemendev\Checkout\Payment\Data\ContainsPaymentsImmutable;
use Siemendev\Checkout\Products\Data\ContainsProductsImmutable;
use Siemendev\Checkout\Products\Data\ContainsQuoteImmutable;
use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutDataImmutable;

/**
 * Immutable checkout data
 * Is used to store the checkout data immutable, this way it can be passed around (e.g. into templates) without
 * the risk of it being modified down the line.
 */
class CheckoutDataImmutable extends AbstractCheckoutDataImmutable implements CheckoutDataInterface
{
    use BillingAddressableCheckoutDataImmutable;
    use IsDeliverableImmutable;
    use HasAgeVerificationImmutable;
    use ContainsProductsImmutable;
    use ContainsQuoteImmutable;
    use ContainsPaymentsImmutable;

    private string $hash;

    private string $identifier;

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public static function createFromCheckoutData(CheckoutData $mutableData): self
    {
        $data = new self();

        $data->hash = $mutableData->getHash();
        $data->identifier = $mutableData->getIdentifier();

        $data->currency = $mutableData->getCurrency();
        $data->finalized = $mutableData->isFinalized();
        $data->locked = $mutableData->isLocked();

        $data->billingAddress = $mutableData->getBillingAddress();

        $data->deliveryOption = $mutableData->getDeliveryOption();
        $data->deliveryAddress = $mutableData->getDeliveryAddress();

        $data->ageVerified = $mutableData->isAgeVerified();

        $data->products = $mutableData->getProducts();

        $data->quote = $mutableData->getQuote();
        $data->calculatedHash = $mutableData->getCalculatedHash();

        $data->payments = $mutableData->getPayments();

        return $data;
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}
