<?php

declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Commerce\Checkout;
use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\Delivery\Step\DeliveryStep;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout/delivery', name: 'checkout_delivery')]
class DeliveryController extends AbstractCheckoutController
{
    public function __invoke(Request $request, Checkout $checkout): Response
    {
        $checkout->recalculate();

        if (!$checkout->isStepAllowed(DeliveryStep::stepIdentifier())) {
            return $this->redirectToCurrentStep();
        }

        $availableOptions = $checkout->getAvailableDeliveryOptions();

        $error = null;
        if ('POST' === $request->getMethod()) {
            $selectedDeliveryOptionIdentifier = $request->request->get('delivery_option');

            foreach ($availableOptions as $option) {
                if ($option->getIdentifier() === $selectedDeliveryOptionIdentifier) {
                    $checkout
                        ->setDeliveryOption($option)
                        ->save()
                    ;

                    return $this->redirectToCurrentStep();
                }
            }

            $error = sprintf('Delivery option with identifier "%s" not found.', $selectedDeliveryOptionIdentifier);
        }

        return $this->render('commerce/steps/delivery.html.twig', [
            'deliveryOptions' => $availableOptions,
            'selectedDeliveryOption' => $checkout->getCheckoutData()->getDeliveryOption(),
            'error' => $error,
            'steps' => $this->getStepsData(),
            'data' => $checkout->getCheckoutData(),
        ]);
    }
}
