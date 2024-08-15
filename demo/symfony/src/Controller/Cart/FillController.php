<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Controller\AbstractCheckoutController;
use Demo\Commerce\Checkout;
use Demo\Commerce\CheckoutProduct;
use Demo\Commerce\Delivery\DhlDeliveryOption;
use Demo\Commerce\Payment\CreditCardPayment;
use Demo\Commerce\Step\AgeVerificationStep;
use Siemendev\Checkout\Delivery\Step\DeliveryStep;
use Siemendev\Checkout\GiftCard\Payment\GiftCardPayment;
use Siemendev\Checkout\Step\Address\Address;
use Siemendev\Checkout\Taxation\VatTypedItemInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart/fill', name: 'cart_fill')]
class FillController extends AbstractCheckoutController
{
    public function __invoke(Checkout $checkout): Response
    {
        $checkout
            ->clear()
            ->switchCurrency('EUR')
            ->setBillingAddress(
                (new Address())
                    ->setName('John Doe')
                    ->setAddressLine1('Test Street 1')
                    ->setPostalCode('12345')
                    ->setCity('Berlin')
                    ->setState('Berlin')
                    ->setCountryCode('DE')
                    ->setCompany(false),
            )
            ->setDeliveryAddress(
                (new Address())
                    ->setName('John Doe')
                    ->setAddressLine1('Test Street 1')
                    ->setPostalCode('12345')
                    ->setCity('Berlin')
                    ->setState('Berlin')
                    ->setCountryCode('DE')
                    ->setCompany(false),
            )
            ->setAgeVerified(true)
            ->setDeliveryOption(new DhlDeliveryOption())
            ->addProduct(
                (new CheckoutProduct())
                    ->setQuantity(2)
                    ->addRequiredStep(DeliveryStep::stepIdentifier())
                    ->setName('Deliverable Product')
                    ->setIdentifier('test-product-1'),
            )
            ->addProduct(
                (new CheckoutProduct())
                    ->setQuantity(1)
                    ->addRequiredStep(AgeVerificationStep::stepIdentifier())
                    ->setName('Digital 18+ Product')
                    ->setIdentifier('test-product-2')
                    ->setVatType(VatTypedItemInterface::VAT_TYPE_LOWER),
            )
            ->addPayment(
                (new CreditCardPayment())
                    ->setIdentifier('credit-card-payment-1')
                    ->setCurrency('EUR')
                    ->setAuthorizedAmount(50000)
                    ->setCardHolder('John Doe')
                    ->setCardNumber('4263982640269299')
                    ->setCardExpiryMonth(2)
                    ->setCardExpiryYear(26)
                    ->setCardCsc('837')
                    ->setAuthorized(true),
            )
            ->addPayment(
                (new GiftCardPayment())
                    ->setIdentifier('test-gift-card-1')
                    ->setAuthorizedAmount(1500)
                    ->setCurrency('EUR'),
            )
            ->recalculate()
            ->lock()
            ->save()
        ;

        return $this->redirectToCurrentStep();
    }
}
