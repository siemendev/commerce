<?php

declare(strict_types=1);

namespace App\Controller\Payment;

use App\Commerce\Checkout;
use App\Commerce\Payment\CreditCardPayment;
use App\Controller\AbstractCheckoutController;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payment/credit-card', name: 'checkout.payment.credit-card')]
class CreditCardPaymentController extends AbstractCheckoutController
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Checkout $checkout): Response
    {
        $data = $checkout->getCheckoutData();

        $payment = (new CreditCardPayment())
            ->setCapturedAmount($data->getOpenTotal())
            ->setCurrency($data->getCurrency())
            ->setCardNumber($request->request->get('card_number'))
            ->setCardHolder($request->request->get('card_holder'))
            ->setCardExpiryMonth((int) $request->request->get('card_expire_month'))
            ->setCardExpiryYear((int) $request->request->get('card_expire_year'))
            ->setCardCsc($request->request->get('card_csc'))
        ;

        // here is where you usually would start by authorizing the credit card payment
        // $externalPaymentId = $externalPaymentProvider->authorize($externalPaymentId, $openTotal);
        $externalPaymentId = (string) rand(100000, 999999); // id mocked for now

        $payment
            ->setIdentifier($externalPaymentId)
            ->setAuthorized(true)
        ;
        $checkout
            ->lock() // don't forget to lock the data as soon as you add payments!
            ->addPayment($payment)
        ;

        return $this->redirectToCurrentStep();
    }
}
