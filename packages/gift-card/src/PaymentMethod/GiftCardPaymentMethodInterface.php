<?php declare(strict_types=1);

namespace Siemendev\Checkout\GiftCard\PaymentMethod;

use Siemendev\Checkout\GiftCard\Payment\GiftCardPaymentInterface;
use Siemendev\Checkout\Payment\Method\PaymentMethodInterface;

/**
 * @implements PaymentMethodInterface<GiftCardPaymentInterface>
 */
interface GiftCardPaymentMethodInterface extends PaymentMethodInterface
{
    public const IDENTIFIER = 'gift-card';
}
