<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\Data;

use Siemendev\Checkout\GiftCard\GiftCardInterface;

interface GiftCardApplicableCheckoutDataInterface
{
    /**
     * @return array<GiftCardInterface>
     */
    public function getGiftCards(): array;
}
