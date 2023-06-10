<?php declare(strict_types=1);

namespace App\Controller\Cart;

use App\Commerce\Delivery\DhlDeliveryOption;
use App\Commerce\Payment\CreditCardPayment;
use App\Commerce\Product;
use App\Commerce\Step\AgeVerificationStep;
use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\Delivery\Step\DeliveryStep;
use Siemendev\Checkout\GiftCard\Payment\GiftCardPayment;
use Siemendev\Checkout\Step\Address\Address;
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
            ->setBillingAddress(
                (new Address())
                    ->setName('John Doe')
                    ->setAddressLine1('Test Street 1')
                    ->setPostalCode('12345')
                    ->setCity('Berlin')
                    ->setState('Berlin')
                    ->setCountryCode('DE')
                    ->setCompany(false)
            )
            ->setDeliveryAddress(
                (new Address())
                    ->setName('John Doe')
                    ->setAddressLine1('Test Street 1')
                    ->setPostalCode('12345')
                    ->setCity('Berlin')
                    ->setState('Berlin')
                    ->setCountryCode('DE')
                    ->setCompany(false)
            )
            ->setAgeVerified(true)
            ->setDeliveryOption(new DhlDeliveryOption())
            ->setProducts([
                (new Product())
                    ->setQuantity(2)
                    ->addRequiredStep(DeliveryStep::stepIdentifier())
                    ->setName('Deliverable Product')
                    ->setIdentifier('test-product-1'),
                (new Product())
                    ->setQuantity(1)
                    ->addRequiredStep(AgeVerificationStep::stepIdentifier())
                    ->setName('Digital 18+ Product')
                    ->setIdentifier('test-product-2')
                    ->setVatType(VatTypedItemInterface::VAT_TYPE_LOWER),
            ])
        ;

        $this->getCheckoutData()->getPayments()->set([
            (new GiftCardPayment())
                ->setIdentifier('test-gift-card-2')
                ->setAmount(500)
                ->setCurrency('EUR'),
//                (new GiftCardPayment())
//                    ->setIdentifier('test-gift-card-3')
//                    ->setValue(5000)
//                    ->setCurrency('EUR'),
//                (new GiftCardPayment())
//                    ->setIdentifier('test-gift-card-4')
//                    ->setValue(2500)
//                    ->setCurrency('EUR'),
            (new CreditCardPayment())
                ->setIdentifier((string) rand(100000, 999999))
                ->setCurrency('EUR')
                ->setAmount(3449)
                ->setCardHolder('John Doe')
                ->setCardNumber('4263982640269299')
                ->setCardExpiryMonth(2)
                ->setCardExpiryYear(26)
                ->setCardCsc('837')
                ->setAuthorized(true),
        ]);

        $this->getQuoteCalculator()->calculate($this->getCheckoutData());
        $this->saveCheckoutData($this->getCheckoutData());

        return $this->redirectToCurrentStep();
    }
}
