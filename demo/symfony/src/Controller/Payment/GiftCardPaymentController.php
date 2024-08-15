<?php

declare(strict_types=1);

namespace App\Controller\Payment;

use Demo\Commerce\Checkout;
use Demo\GiftCard\GiftCardRepository;
use Demo\Repository\ObjectNotFoundException;
use Siemendev\Checkout\GiftCard\Payment\GiftCardPayment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payment/gift-card', name: 'checkout.payment.gift-card')]
class GiftCardPaymentController extends AbstractController
{
    private const PAYMENT_IDENTIFIER_FORMAT = 'gift-card_%s';

    public function __invoke(
        Request $request,
        GiftCardRepository $giftCardRepository,
        Checkout $checkout,
    ): RedirectResponse {
        $code = $request->request->get('gift-card-code');

        try {
            $giftCard = $giftCardRepository->load($code);
        } catch (ObjectNotFoundException) {
            $this->addFlash('error', 'Gift card not found');

            return $this->redirectToRoute('checkout_payment');
        }

        if ($giftCard->balance <= 0) {
            $this->addFlash('error', 'Gift card has no balance');

            return $this->redirectToRoute('checkout_payment');
        }

        if ($checkout->getCheckoutData()->getCurrency() !== $giftCard->currency) {
            $this->addFlash('error', 'Gift card currency does not match checkout currency');

            return $this->redirectToRoute('checkout_payment');
        }

        foreach ($checkout->getCheckoutData()->getPayments() as $existingPayment) {
            if ($existingPayment instanceof GiftCardPayment && $existingPayment->getGiftCardCode() === $code) {
                $this->addFlash('error', 'Gift card already added');

                return $this->redirectToRoute('checkout_payment');
            }
        }

        $checkout
            ->addPayment(
                (new GiftCardPayment())
                    ->setIdentifier(sprintf(self::PAYMENT_IDENTIFIER_FORMAT, $code))
                    ->setGiftCardCode($code)
                    ->setAuthorizedAmount($giftCard->balance)
                    ->setAuthorized(true)
                    ->setCurrency($giftCard->currency),
            )
            // when you add a payment that needs re-authorization, you should lock the data here with $checkout->lock()
            // we do not lock the data, since the gift card needs no re-authorization on a changed cart or pricing
            ->save()
        ;

        return $this->redirectToRoute('checkout_payment');
    }
}
