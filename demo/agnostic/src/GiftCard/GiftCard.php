<?php

declare(strict_types=1);

namespace Demo\GiftCard;

use Demo\Repository\IdentifiableInterface;
use Symfony\Component\Serializer\Attribute\Ignore;

class GiftCard implements IdentifiableInterface
{
    public string $code;

    public string $currency;

    public int $balance;

    #[Ignore]
    public function getIdentifier(): string
    {
        return $this->code;
    }
}
