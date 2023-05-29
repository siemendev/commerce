<?php declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\Delivery\Option\Resolver\DeliveryOptionsResolverInterface;
use Siemendev\Checkout\Delivery\Step\DeliveryStep;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout/delivery', name: 'checkout_delivery')]
class DeliveryController extends AbstractCheckoutController
{
    public function __invoke(Request $request, DeliveryOptionsResolverInterface $optionsResolver): Response
    {
        $error = null;

        if (!$this->getStepMachine()->isStepAllowed($this->getCheckoutData(), DeliveryStep::stepIdentifier())) {
            return $this->redirectToCurrentStep();
        }

        $availableOptions = $optionsResolver->getAvailableOptions($this->getCheckoutData());

        if ($request->getMethod() === 'POST') {
            $selectedDeliveryOptionIdentifier = $request->request->get('delivery_option');

            foreach ($availableOptions as $option) {
                if ($option->getIdentifier() === $selectedDeliveryOptionIdentifier) {
                    $this->saveCheckoutData(
                        $this->getCheckoutData()->setDeliveryOption($option)
                    );

                    return $this->redirectToCurrentStep();
                }
            }

            $error = sprintf('Delivery option with identifier "%s" not found.', $selectedDeliveryOptionIdentifier);
        }

        return $this->render('commerce/steps/delivery.html.twig', [
            'deliveryOptions' => $availableOptions,
            'error' => $error,
            'steps' => $this->getStepsData(),
            'data' => $this->getCheckoutData(),
        ]);
    }
}
