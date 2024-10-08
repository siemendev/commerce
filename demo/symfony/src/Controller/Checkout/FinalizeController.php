<?php

declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Controller\AbstractCheckoutController;
use Demo\Commerce\Checkout;
use Siemendev\Checkout\Finalize\CheckoutFinalizationExceptionWrapper;
use Siemendev\Checkout\Finalize\CheckoutNotFinalizableException;
use Siemendev\Checkout\Finalize\UnknownFinalizationStepException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[Route('/checkout/finish', name: 'checkout_finalize')]
class FinalizeController extends AbstractCheckoutController
{
    /**
     * @throws UnknownFinalizationStepException
     * @throws Throwable
     */
    public function __invoke(Request $request, Checkout $checkout): Response
    {
        $checkout->recalculate();

        if (!$checkout->isValid()) {
            return $this->redirectToCurrentStep();
        }

        try {
            $checkout->finalize();
        } catch (CheckoutFinalizationExceptionWrapper $e) {
            $this->addFlash('error', $e->getMessage());
            foreach ($e->getRollbackExceptions() as $rollbackException) {
                $this->addFlash('error', $rollbackException->getMessage());
            }

            if (!$e->getPrevious() instanceof CheckoutNotFinalizableException) {
                throw $e->getPrevious();
            }

            return $this->redirectToCurrentStep();
        }

        if ($checkout->getCheckoutData()->isFinalized()) {
            $checkout->clear();
        }

        return $this->render('commerce/steps/finalize.html.twig', ['data' => $checkout->getCheckoutData()]);
    }
}
