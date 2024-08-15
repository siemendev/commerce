<?php

declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Controller\AbstractCheckoutController;
use Demo\Commerce\Checkout;
use Siemendev\Checkout\Payment\Step\PaymentStep;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout/payment', name: 'checkout_payment')]
class PaymentController extends AbstractCheckoutController
{
    public function __invoke(Checkout $checkout): Response
    {
        $checkout->recalculate();

        if (!$checkout->isStepAllowed(PaymentStep::stepIdentifier())) {
            return $this->redirectToCurrentStep();
        }

        return $this->render('commerce/steps/payment.html.twig', [
            'paymentMethods' => $checkout->getEligiblePaymentMethods(),
            'openTotal' => $checkout->getCheckoutData()->getOpenTotal(),
            'steps' => $this->getStepsData(),
            'data' => $checkout->getCheckoutData(),
        ]);
    }
}
