<?php

declare(strict_types=1);

namespace App\Controller\Payment;

use Demo\Commerce\Checkout;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use InvalidArgumentException;

#[Route('/payment/remove', name: 'checkout.payment.remove')]
class RemovePaymentController extends AbstractController
{
    public function __invoke(Request $request, Checkout $checkout): Response
    {
        try {
            // todo properly remove the authorization on the payment
            $checkout->removePayment($request->get('payment_identifier'));
        } catch (InvalidArgumentException) {
            $this->addFlash('error', 'Payment not found');
        }

        return $this->redirectToRoute('checkout_payment');
    }
}
