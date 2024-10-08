<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Taxation;

use Mpociot\VatCalculator\VatCalculator;
use Siemendev\Checkout\Products\Product\ProductInterface;
use Siemendev\Checkout\Step\Address\Billing\BillingAddressableCheckoutDataInterface;

class EuropeanVatTaxResolver implements EuropeanVatTaxResolverInterface
{
    public function __construct(private readonly ?string $businessCountryCode = null) {}

    public function getProductTaxRate(ProductInterface $product, BillingAddressableCheckoutDataInterface $data): float
    {
        $vatCalculator = new VatCalculator();
        if (null !== $this->businessCountryCode) {
            $vatCalculator->setBusinessCountryCode($this->businessCountryCode);
        }
        $vatCalculator->calculate(
            netPrice: 0, // we do not need a price here since we just need the vat rate. The price is calculated later.
            countryCode: $data->getBillingAddress()?->getCountryCode(),
            postalCode: $data->getBillingAddress()?->getPostalCode(),
            company: $data->getBillingAddress()?->isCompany(),
            type: $product instanceof VatTypedItemInterface ? $product->getVatType() : VatTypedItemInterface::VAT_TYPE_DEFAULT,
        );

        return $vatCalculator->getTaxRate() * 100;
    }
}
