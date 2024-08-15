<?php

declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Controller\AbstractCheckoutController;
use Demo\Commerce\Checkout;
use Siemendev\Checkout\Step\Summary\SummaryStep;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout/summary', name: 'checkout_summary')]
class SummaryController extends AbstractCheckoutController
{
    public function __invoke(Request $request, Checkout $checkout): Response
    {
        $checkout->recalculate();

        if (!$checkout->isStepAllowed(SummaryStep::stepIdentifier())) {
            return $this->redirectToCurrentStep();
        }

        return $this->render('commerce/steps/summary.html.twig', [
            'steps' => $this->getStepsData(),
            'data' => $checkout->getCheckoutData(),
            'finalizable' => $checkout->isValid(),
        ]);
    }
}
