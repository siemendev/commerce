<?php declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\Delivery\Option\Resolver\DeliveryOptionsResolverInterface;
use Siemendev\Checkout\Payment\Step\PaymentStep;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout/payment/products', name: 'checkout_product_payment')]
class ProductPaymentController extends AbstractCheckoutController
{
    public function __invoke(Request $request, DeliveryOptionsResolverInterface $optionsResolver): Response
    {
        if (!$this->getStepMachine()->isStepAllowed($this->getCheckoutData(), PaymentStep::stepIdentifier())) {
            return $this->redirectToCurrentStep();
        }

        return $this->render('commerce/steps/product_payment.html.twig', [
            'quote' => $this->getProductsQuoteGenerator()->generate($this->getCheckoutData()),
            'steps' => $this->getStepsData(),
            'data' => $this->getCheckoutData(),
        ]);
    }
}