<?php declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\Finalize\CheckoutFinalizationExceptionWrapper;
use Siemendev\Checkout\Finalize\CheckoutFinalizerInterface;
use Siemendev\Checkout\Finalize\CheckoutNotFinalizableException;
use Siemendev\Checkout\Finalize\UnknownFinalizationStepException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout/finish', name: 'checkout_finalize')]
class FinalizeController extends AbstractCheckoutController
{
    /**
     * @throws UnknownFinalizationStepException
     */
    public function __invoke(Request $request, CheckoutFinalizerInterface $checkoutFinalizer): Response
    {
        $checkoutData = $this->getCheckoutData();
        $this->getQuoteCalculator()->calculate($checkoutData);

        if (!$this->getStepMachine()->isValid($checkoutData)) {
            return $this->redirectToCurrentStep();
        }

        try {
            $checkoutFinalizer->finalize($checkoutData);
        } catch (CheckoutFinalizationExceptionWrapper $e) {
            $this->addFlash('error', $e->getMessage());

            return $this->redirectToCurrentStep();
        }

        if ($checkoutData->isFinalized()) {
            $this->clearCheckoutData();
        }

        return $this->render('commerce/steps/finalize.html.twig', ['data' => $checkoutData]);
    }
}
