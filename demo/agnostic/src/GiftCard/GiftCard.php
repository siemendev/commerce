<?php

declare(strict_types=1);

namespace Demo\GiftCard;

use Demo\Repository\IdentifiableInterface;

class GiftCard implements IdentifiableInterface
{
    public string $code;

    public string $currency;

    public int $balance;

    public function getIdentifier(): string
    {
        return $this->code;
    }
}
