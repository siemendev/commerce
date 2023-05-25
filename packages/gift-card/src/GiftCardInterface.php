<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard;

interface GiftCardInterface
{
    /**
     * The unique identifier of the gift card for later reference.
     */
    public function getIdentifier(): string;

    /**
     * The amount of the gift card that can possibly be used.
     */
    public function getValue(): int;

    /**
     * The amount of the gift card that has actually been used (partial use of gift card).
     */
    public function getUsedValue(): int;

    /**
     * The amount of the gift card that has actually been used (partial use of gift card).
     */
    public function updateUsedValue(int $usedValue): static;

    /**
     * The currency of the gift card. Only gift cards with the same currency as the order can be used.
     */
    public function getCurrency(): string;
}
