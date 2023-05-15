<?php declare(strict_types=1);

namespace Siemendev\Checkout\Taxation;

use Mpociot\VatCalculator\VatCalculator;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Item\ItemInterface;

class EuropeanVatEuropeanVatTaxResolver implements EuropeanVatTaxResolverInterface
{
    public function __construct(private readonly ?string $businessCountryCode = null)
    {
    }

    public function getItemTaxRate(ItemInterface $item, CheckoutDataInterface $data): float
    {
        $vatCalculator = new VatCalculator();
        if ($this->businessCountryCode !== null) {
            $vatCalculator->setBusinessCountryCode($this->businessCountryCode);
        }
        $vatCalculator->calculate(
            netPrice: 0, // we do not need a price here since we just need the vat rate. The price is calculated later.
            countryCode: $data->getBillingAddress()?->getCountryCode(),
            postalCode: $data->getBillingAddress()?->getPostalCode(),
            company: $data->getBillingAddress()?->isCompany(),
            type: $item instanceof VatTypedItemInterface ? $item->getVatType() : VatTypedItemInterface::VAT_TYPE_DEFAULT,
        );

        return $vatCalculator->getTaxRate() * 100;
    }
}
