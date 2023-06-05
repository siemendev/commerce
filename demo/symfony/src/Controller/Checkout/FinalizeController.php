<?php declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\Finalize\CheckoutFinalizerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout/finish', name: 'checkout_finalize')]
class FinalizeController extends AbstractCheckoutController
{
    public function __invoke(Request $request, CheckoutFinalizerInterface $checkoutFinalizer): Response
    {
        $checkoutData = $this->getCheckoutData();
        $this->getQuoteCalculator()->calculate($checkoutData);

        if (!$this->getStepMachine()->isValid($checkoutData)) {
            return $this->redirectToCurrentStep();
        }

        // todo catch exception and redirect to summary page with error message
        $checkoutFinalizer->finalize($checkoutData);

        return $this->render('commerce/steps/finalize.html.twig', ['data' => $checkoutData]);
    }
}
