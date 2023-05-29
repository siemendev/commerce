<?php declare(strict_types=1);

namespace App\Controller\Cart;

use App\Commerce\Product;
use App\Commerce\Step\AgeVerificationStep;
use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\GiftCard\GiftCard;
use Siemendev\Checkout\Step\Address\Delivery\DeliveryAddressStep;
use Siemendev\Checkout\Taxation\VatTypedItemInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart/fill', name: 'cart_fill')]
class FillController extends AbstractCheckoutController
{
    public function __invoke(): Response
    {
        $this->getCheckoutData()
            ->setCurrency('EUR')
            ->setProducts([
                (new Product())
                    ->setQuantity(2)
                    ->addRequiredStep(DeliveryAddressStep::stepIdentifier())
                    ->setName('Deliverable Product')
                    ->setIdentifier('test-product-1'),
                (new Product())
                    ->setQuantity(1)
                    ->addRequiredStep(AgeVerificationStep::stepIdentifier())
                    ->setName('Digital 18+ Product')
                    ->setIdentifier('test-product-2')
                    ->setVatType(VatTypedItemInterface::VAT_TYPE_LOWER),
            ])
//            ->setSubscriptions([
//                (new Subscription())
//                    ->addRequiredStep(AgeVerificationStep::stepIdentifier())
//                    ->setName('Test Subscription One')
//                    ->setId('test-subscription-1'),
//            ])
            ->setGiftCards([
                (new GiftCard()) // this should be ignored since it has the wrong currency
                    ->setIdentifier('test-gift-card-1')
                    ->setValue(15000)
                    ->setCurrency('USD'),
                (new GiftCard())
                    ->setIdentifier('test-gift-card-2')
                    ->setValue(500)
                    ->setCurrency('EUR'),
//                (new GiftCard())
//                    ->setIdentifier('test-gift-card-3')
//                    ->setValue(5000)
//                    ->setCurrency('EUR'),
//                (new GiftCard())
//                    ->setIdentifier('test-gift-card-4')
//                    ->setValue(2500)
//                    ->setCurrency('EUR'),
            ])
        ;

        $this->saveCheckoutData($this->getCheckoutData());

        return $this->redirectToRoute('checkout_cart');
    }
}
