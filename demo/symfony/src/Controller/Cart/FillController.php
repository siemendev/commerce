<?php declare(strict_types=1);

namespace App\Controller\Cart;

use App\Commerce\Item;
use App\Commerce\Step\AgeVerificationStep;
use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\Step\Address\Delivery\DeliveryAddressStep;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart/fill', name: 'cart_fill')]
class FillController extends AbstractCheckoutController
{
    public function __invoke(): Response
    {
        $item1 = new Item();
        $item1->name = 'Test 1';
        $item1->id = 'test-1';
        $item1->quantity = 2;
        $item1->requiresSteps = [DeliveryAddressStep::stepIdentifier()];

        $item2 = new Item();
        $item2->name = 'Test 2';
        $item2->id = 'test-2';
        $item2->quantity = 1;
        $item2->requiresSteps = [AgeVerificationStep::stepIdentifier()];

        $this->getCheckoutSession()->setItems([$item1, $item2]);

        $this->saveCheckoutSession($this->getCheckoutSession());

        return $this->redirectToRoute('checkout_cart');
    }
}
