<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\AdditionalCost;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\GiftCard\Data\GiftCardApplicableCheckoutDataInterface;
use Siemendev\Checkout\Products\AdditionalCost\AdditionalCostProviderInterface;
use Siemendev\Checkout\Products\Quote\QuoteInterface;

class GiftCardAdditionalCostProvider implements AdditionalCostProviderInterface
{
    public function eligible(CheckoutDataInterface $data): bool
    {
        return $data instanceof GiftCardApplicableCheckoutDataInterface;
    }

    /**
     * @param GiftCardApplicableCheckoutDataInterface&CheckoutDataInterface $data
     */
    public function getAdditionalCosts(CheckoutDataInterface $data, QuoteInterface $quote): array
    {
        $additionalCosts = [];

        $openTotal = $quote->getTotalGross();

        foreach ($data->getGiftCards() as $giftCard) {
            if ($giftCard->getCurrency() !== $data->getCurrency()) {
                // todo add way to let user know we can't use this gift card because of currency mismatch
                continue;
            }

            // If the total is 0 or less, we don't need to add a gift card
            if ($openTotal <= 0) {
                break;
            }
            $value = $giftCard->getValue();
            // If the gift card value is higher than the open total, we need to reduce the (used) value
            if ($value > $openTotal) {
                $value = $openTotal;
            }
            $openTotal -= $value;
            $giftCard->updateUsedValue($value);

            $additionalCosts[] = (new GiftCardAdditionalCost())
                ->setGiftCardValue($value)
            ;
        }

        return $additionalCosts;
    }
}
