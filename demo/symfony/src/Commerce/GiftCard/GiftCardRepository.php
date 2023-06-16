<?php

declare(strict_types=1);

namespace App\Commerce\GiftCard;

use App\ObjectExporter\ObjectExporter;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\GiftCard\Payment\GiftCardPaymentInterface;
use Siemendev\Checkout\GiftCard\Repository\GiftCardRepositoryInterface;

class GiftCardRepository implements GiftCardRepositoryInterface
{
    private const PATH = 'orders/%s/payments/%s.xml';

    public function __construct(
        private readonly ObjectExporter $objectExporter,
    ) {
    }

    public function redeem(GiftCardPaymentInterface $payment, CheckoutDataInterface $data, int $amount): void
    {
        $this->objectExporter->export(
            (clone $payment)->setCapturedAmount($amount),
            sprintf(self::PATH, $data->getIdentifier(), $payment->getIdentifier()),
        );
    }

    public function rollback(GiftCardPaymentInterface $payment, CheckoutDataInterface $data): void
    {
        $this->objectExporter->remove(
            sprintf(self::PATH, $data->getIdentifier(), $payment->getIdentifier()),
        );
    }
}
