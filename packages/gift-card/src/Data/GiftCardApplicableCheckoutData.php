<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\Data;

use Siemendev\Checkout\GiftCard\GiftCardInterface;

trait GiftCardApplicableCheckoutData
{
    /** @var array<GiftCardInterface> */
    private array $giftCards = [];

    public function getGiftCards(): array
    {
        return $this->giftCards;
    }

    public function setGiftCards(array $giftCards): static
    {
        $this->giftCards = $giftCards;

        return $this;
    }

    public function addGiftCard(GiftCardInterface $giftCard): static
    {
        $this->giftCards[] = $giftCard;

        return $this;
    }
}
