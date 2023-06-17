<?php declare(strict_types=1);

namespace App\GiftCard;

use App\Repository\IdentifiableInterface;

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
