<?php declare(strict_types=1);

namespace App\Commerce\GiftCard;

use App\ObjectExporter\ObjectExporter;
use Siemendev\Checkout\GiftCard\Payment\GiftCardPaymentInterface;
use Siemendev\Checkout\GiftCard\Repository\GiftCardRepositoryInterface;

class GiftCardRepository implements GiftCardRepositoryInterface
{
    public function __construct(
        private readonly ObjectExporter $objectExporter,
    ) {
    }

    public function redeem(GiftCardPaymentInterface $payment): void
    {
        $this->objectExporter->export($payment, 'gift-cards/' . $payment->getIdentifier() .'.xml');
    }

    public function rollback(GiftCardPaymentInterface $payment): void
    {
        $this->objectExporter->remove('gift-cards/' . $payment->getIdentifier() .'.xml');
    }
}
