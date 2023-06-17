<?php

declare(strict_types=1);

namespace App\Commerce\GiftCard;

use App\GiftCard\GiftCardRepository;
use App\ObjectExporter\ObjectExporter;
use App\Repository\ObjectNotFoundException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\GiftCard\Payment\GiftCardPaymentInterface;
use Siemendev\Checkout\GiftCard\Capture\GiftCardCapturingManagerInterface;
use Siemendev\Checkout\Payment\Method\PaymentCaptureRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentNotCapturableException;

class GiftCardCapturingManager implements GiftCardCapturingManagerInterface
{
    private const PATH = 'orders/%s/payments/%s.xml';

    public function __construct(
        private readonly GiftCardRepository $giftCardRepository,
        private readonly ObjectExporter $objectExporter,
    ) {
    }

    public function redeem(GiftCardPaymentInterface $payment, CheckoutDataInterface $data, int $amount): void
    {
        try {
            $giftCard = $this->giftCardRepository->load($payment->getGiftCardCode());
        } catch (ObjectNotFoundException $e) {
            throw new PaymentNotCapturableException('Gift card not found', $e->getCode(), $e);
        }

        if ($giftCard->balance < $amount) {
            throw new PaymentNotCapturableException('Gift card balance too low');
        }

        $giftCard->balance -= $amount;
        $this->giftCardRepository->save($giftCard);

        $this->objectExporter->export(
            (clone $payment)->setCapturedAmount($amount),
            sprintf(self::PATH, $data->getIdentifier(), $payment->getIdentifier()),
        );
    }

    public function rollback(GiftCardPaymentInterface $payment, CheckoutDataInterface $data): void
    {
        try {
            $giftCard = $this->giftCardRepository->load($payment->getGiftCardCode());
        } catch (ObjectNotFoundException $e) {
            throw new PaymentCaptureRollbackException('Gift card not found', $e->getCode(), $e);
        }
        $giftCard->balance += $payment->getCapturedAmount();
        $this->giftCardRepository->save($giftCard);

        $this->objectExporter->remove(
            sprintf(self::PATH, $data->getIdentifier(), $payment->getIdentifier()),
        );
    }
}
