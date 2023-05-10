<?php declare(strict_types=1);

namespace App\Controller\Cart;

use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\Step\Cart\CartStep;
use Siemendev\Checkout\Step\Exception\AssignedValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'checkout_cart')]
class OverviewController extends AbstractCheckoutController
{
    public function __invoke(): Response
    {
        $data = [
            'quote' => $this->getCheckout()->getQuote($this->getCheckoutSession()),
            'continue' => $this->getCurrentStepUrl(),
        ];
        try {
            $this->getCheckout()->validateStep($this->getCheckoutSession(), CartStep::STEP_IDENTIFIER);
        } catch (AssignedValidationException $e) {
            if ($e->step::stepIdentifier() === CartStep::STEP_IDENTIFIER) {
                $data['error'] = $e->getMessage();
            }
        }

        return $this->render('commerce/steps/cart.html.twig', $data);
    }
}
