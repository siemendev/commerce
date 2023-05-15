<?php declare(strict_types=1);

namespace App\Controller\Cart;

use App\Commerce\Product;
use App\Commerce\Step\AgeVerifiableCheckoutDataInterface;
use App\Commerce\Subscription;
use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\GiftCard\GiftCard;
use Siemendev\Checkout\Step\Delivery\DeliverableCheckoutDataInterface;
use Siemendev\Checkout\Taxation\VatTypedItemInterface;
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
                    ->addRequiredCheckoutDataInterface(DeliverableCheckoutDataInterface::class)
                    ->setName('Deliverable Product')
                    ->setId('test-product-1'),
                (new Product())
                    ->setQuantity(1)
                    ->addRequiredCheckoutDataInterface(AgeVerifiableCheckoutDataInterface::class)
                    ->setName('Digital 18+ Product')
                    ->setId('test-product-2')
                    ->setVatType(VatTypedItemInterface::VAT_TYPE_LOWER),
            ])
            ->setSubscriptions([
                (new Subscription())
                    ->addRequiredCheckoutDataInterface(AgeVerifiableCheckoutDataInterface::class)
                    ->setName('Test Subscription One')
                    ->setId('test-subscription-1'),
            ])
        ;
        $this->getCheckoutData()->setGiftCards([
            (new GiftCard())
                ->setIdentifier('test-gift-card-1')
                ->setValue(1500)
                ->setCurrency('EUR')
        ]);

        $this->saveCheckoutData($this->getCheckoutData());

        return $this->redirectToRoute('checkout_cart');
    }
}
