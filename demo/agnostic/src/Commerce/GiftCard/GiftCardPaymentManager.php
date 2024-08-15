<?php

declare(strict_types=1);

namespace Demo\Commerce\GiftCard;

use Demo\GiftCard\GiftCardRepository;
use Demo\ObjectExporter\ObjectExporter;
use Demo\Repository\ObjectNotFoundException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\GiftCard\Payment\GiftCardPaymentInterface;
use Siemendev\Checkout\GiftCard\Payment\GiftCardPaymentManagerInterface;
use Siemendev\Checkout\Payment\Method\PaymentCaptureRollbackException;
use Siemendev\Checkout\Payment\Method\PaymentNotCapturableException;

class GiftCardPaymentManager implements GiftCardPaymentManagerInterface
{
    private const PATH = __DIR__ . '/../../../data/orders/%s/payments/%s.xml';

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

    public function rollbackRedeem(GiftCardPaymentInterface $payment, CheckoutDataInterface $data): void
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

    public function rollbackReservation(GiftCardPaymentInterface $payment, CheckoutDataInterface $data): void
    {
        // do nothing because we do not reserve gift card balance
    }
}
