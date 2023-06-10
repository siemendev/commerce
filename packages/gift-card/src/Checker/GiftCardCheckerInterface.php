<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\Checker;

use Siemendev\Checkout\Products\Data\QuotedCheckoutDataInterface;

interface GiftCardCheckerInterface
{
    public function checkGiftCardPaymentAvailability(QuotedCheckoutDataInterface $data): void;
}
