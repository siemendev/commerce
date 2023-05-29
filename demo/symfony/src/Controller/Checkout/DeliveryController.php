<?php declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Commerce\Step\AgeVerificationStep;
use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\Delivery\Step\DeliveryStep;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout/delivery', name: 'checkout_delivery')]
class DeliveryController extends AbstractCheckoutController
{
    public function __invoke(Request $request): Response
    {
        if (!$this->getStepMachine()->isStepAllowed($this->getCheckoutData(), DeliveryStep::stepIdentifier())) {
            return $this->redirectToCurrentStep();
        }

        if ($request->getMethod() === 'POST') {
            return $this->redirectToCurrentStep();
        }

        return $this->render('commerce/steps/delivery.html.twig', [
            'steps' => $this->getStepsData(),
            'data' => $this->getCheckoutData(),
        ]);
    }
}
