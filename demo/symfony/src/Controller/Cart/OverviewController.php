<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Controller\AbstractCheckoutController;
use Demo\Commerce\Checkout;
use Demo\Commerce\Step\CartStep;
use Siemendev\Checkout\Step\Exception\AssignedValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'checkout_cart')]
class OverviewController extends AbstractCheckoutController
{
    public function __invoke(Checkout $checkout): Response
    {
        $checkout->recalculate();

        $data = [
            'continue' => $this->getCurrentStepUrl(),
            'step_name' => $this->getCurrentStepIdentifier(),
            'data' => $checkout->getCheckoutData(),
        ];
        try {
            $checkout->validateStep(CartStep::stepIdentifier());
        } catch (AssignedValidationException $e) {
            if ($e->step::stepIdentifier() === CartStep::stepIdentifier()) {
                $data['error'] = $e->getMessage();
            }
        }

        return $this->render('commerce/steps/cart.html.twig', $data);
    }
}
