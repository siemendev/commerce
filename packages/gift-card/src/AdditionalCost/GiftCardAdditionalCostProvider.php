<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\AdditionalCost;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\GiftCard\Data\GiftCardApplicableCheckoutDataInterface;
use Siemendev\Checkout\Products\AdditionalCost\AdditionalCostProviderInterface;

class GiftCardAdditionalCostProvider implements AdditionalCostProviderInterface
{
    public function eligible(CheckoutDataInterface $data): bool
    {
        return $data instanceof GiftCardApplicableCheckoutDataInterface;
    }

    /**
     * @param GiftCardApplicableCheckoutDataInterface&CheckoutDataInterface $data
     */
    public function getAdditionalCosts(CheckoutDataInterface $data): array
    {
        $additionalCosts = [];

        foreach ($data->getGiftCards() as $giftCard) {
            $additionalCosts[] = (new GiftCardAdditionalCost())
                ->setGiftCardValue($giftCard->getValue())
                ->setCurrency($giftCard->getCurrency())
            ;
        }

        return $additionalCosts;
    }
}
