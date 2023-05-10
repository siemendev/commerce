<?php declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Commerce\Step\AgeVerificationStep;
use App\Controller\AbstractCheckoutController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout/age-verification', name: 'checkout_age_verification')]
class AgeVerificationController extends AbstractCheckoutController
{
    public function __invoke(Request $request): Response
    {
        if (!$this->getCheckout()->isStepAllowed($this->getCheckoutSession(), AgeVerificationStep::stepIdentifier())) {
            return $this->redirectToCurrentStep();
        }

        if ($request->getMethod() === 'POST') {
            $this->getCheckoutSession()->setAgeVerified($request->request->has('age_verification'));

            return $this->redirectToCurrentStep();
        }

        return $this->render('commerce/steps/age_verification.html.twig', [
            'verified' => $this->getCheckoutSession()->isAgeVerified(),
            'steps' => $this->getStepsData(),
        ]);
    }
}
