<?php declare(strict_types=1);

namespace App\Controller\Cart;

use App\Commerce\Product;
use App\Commerce\Step\AgeVerificationStep;
use App\Commerce\Subscription;
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
        $this->getCheckoutData()->getCart()
            ->setProducts([
                (new Product())
                    ->setQuantity(2)
//                    ->addRequiredStep(DeliveryAddressStep::stepIdentifier())
                    ->setName('Test Product One')
                    ->setId('test-product-1'),
            ])
            ->setSubscriptions([
                (new Subscription())
                    ->addRequiredStep(AgeVerificationStep::stepIdentifier())
                    ->setName('Test Subscription One')
                    ->setId('test-subscription-1'),
            ])
        ;

        $this->saveCheckoutData($this->getCheckoutData());

        return $this->redirectToRoute('checkout_cart');
    }
}
