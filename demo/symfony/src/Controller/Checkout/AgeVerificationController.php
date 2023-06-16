<?php

declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Commerce\Checkout;
use App\Commerce\Step\AgeVerificationStep;
use App\Controller\AbstractCheckoutController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout/age-verification', name: 'checkout_age_verification')]
class AgeVerificationController extends AbstractCheckoutController
{
    public function __invoke(Request $request, Checkout $checkout): Response
    {
        $checkout->recalculate();

        if (!$checkout->isStepAllowed(AgeVerificationStep::stepIdentifier())) {
            return $this->redirectToCurrentStep();
        }

        if ('POST' === $request->getMethod()) {
            $checkout
                ->setAgeVerified($request->request->has('age_verification'))
                ->save()
            ;

            return $this->redirectToCurrentStep();
        }

        return $this->render('commerce/steps/age_verification.html.twig', [
            'verified' => $checkout->isAgeVerified(),
            'steps' => $this->getStepsData(),
            'data' => $checkout->getCheckoutData(),
        ]);
    }
}
