<?php declare(strict_types=1);

namespace App\Controller\Cart;

use App\Commerce\Step\CartStep;
use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\Step\Exception\AssignedValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart', name: 'checkout_cart')]
class OverviewController extends AbstractCheckoutController
{
    public function __invoke(): Response
    {
        $data = [
            'quote' => $this->getProductsQuoteGenerator()->generate($this->getCheckoutData()),
            'continue' => $this->getCurrentStepUrl(),
            'step_name' => $this->getCurrentStepIdentifier()
        ];
        try {
            $this->getStepMachine()->validateStep($this->getCheckoutData(), CartStep::stepIdentifier());
        } catch (AssignedValidationException $e) {
            if ($e->step::stepIdentifier() === CartStep::stepIdentifier()) {
                $data['error'] = $e->getMessage();
            }
        }

        return $this->render('commerce/steps/cart.html.twig', $data);
    }
}
