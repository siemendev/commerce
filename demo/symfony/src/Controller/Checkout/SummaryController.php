<?php declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\Step\StepInterface;
use Siemendev\Checkout\Step\Summary\SummaryStep;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout/summary', name: 'checkout_summary')]
class SummaryController extends AbstractCheckoutController
{
    public function __invoke(): Response
    {
        if (!$this->getStepMachine()->isStepAllowed($this->getCheckoutData(), SummaryStep::stepIdentifier())) {
            return $this->redirectToCurrentStep();
        }

        return $this->render('commerce/steps/summary.html.twig', [
            'steps' => $this->getStepsData(),
            'quote' => $this->getProductsQuoteGenerator()->generate($this->getCheckoutData()),
            'data' => $this->getCheckoutData(),
        ]);
    }
}
