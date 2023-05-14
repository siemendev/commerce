<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard;

interface GiftCardInterface
{
    public function getIdentifier(): string;

    public function getValue(): int;

    public function getCurrency(): string;
}
