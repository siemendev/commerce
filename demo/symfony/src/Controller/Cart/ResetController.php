<?php declare(strict_types=1);

namespace App\Controller\Cart;

use App\Commerce\Product;
use App\Commerce\Step\AgeVerificationStep;
use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\Step\Address\Delivery\DeliveryAddressStep;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart/clear', name: 'cart_clear')]
#[Route('/cart/reset', name: 'cart_reset')]
class ResetController extends AbstractCheckoutController
{
    public function __invoke(Request $request): Response
    {
        $request->getSession()->remove('checkout_data');

        return $this->redirectToRoute('checkout_cart');
    }
}
