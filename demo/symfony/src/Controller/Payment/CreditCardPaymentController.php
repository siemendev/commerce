<?php

declare(strict_types=1);

namespace App\Controller\Payment;

use App\Commerce\Checkout;
use App\Commerce\Payment\CreditCardPayment;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payment/credit-card', name: 'checkout.payment.credit-card')]
class CreditCardPaymentController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Checkout $checkout): Response
    {
        $amount = $checkout->getCheckoutData()->getOpenTotal();

        $payment = (new CreditCardPayment())
            ->setCurrency($checkout->getCheckoutData()->getCurrency())
            ->setCardNumber($request->request->get('card_number'))
            ->setCardHolder($request->request->get('card_holder'))
            ->setCardExpiryMonth((int) $request->request->get('card_expire_month'))
            ->setCardExpiryYear((int) $request->request->get('card_expire_year'))
            ->setCardCsc($request->request->get('card_csc'))
        ;

        // here is where you usually would start by authorizing the credit card payment
        // $externalPaymentId = $externalPaymentProvider->authorize($externalPaymentId, $amount);
        $externalPaymentId = (string) rand(100000, 999999); // id mocked for now

        $payment
            ->setIdentifier($externalPaymentId)
            ->setAuthorizedAmount($amount)
            ->setAuthorized(true)
        ;
        $checkout
            ->lock() // don't forget to lock the data as soon as you add payments!
            ->addPayment($payment)
        ;

        return $this->redirectToRoute('checkout_payment');
    }
}
