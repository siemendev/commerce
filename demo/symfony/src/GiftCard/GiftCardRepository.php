<?php declare(strict_types=1);

namespace App\GiftCard;

use App\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<GiftCard>
 */
class GiftCardRepository extends AbstractRepository
{
    public static function getDirectory(): string
    {
        return __DIR__ . '/../../var/gift-cards';
    }

    public static function getClass(): string
    {
        return GiftCard::class;
    }
}
