<?php

declare(strict_types=1);

namespace Demo\GiftCard;

use Demo\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<GiftCard>
 */
class GiftCardRepository extends AbstractRepository
{
    public static function getDirectory(): string
    {
        return __DIR__ . '/../../data/gift-cards';
    }

    public static function getClass(): string
    {
        return GiftCard::class;
    }
}
