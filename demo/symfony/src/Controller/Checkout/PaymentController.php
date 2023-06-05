<?php declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Controller\AbstractCheckoutController;
use RuntimeException;
use Siemendev\Checkout\Delivery\Option\Resolver\DeliveryOptionsResolverInterface;
use Siemendev\Checkout\Payment\Method\PaymentMethodsProviderInterface;
use Siemendev\Checkout\Payment\Step\PaymentStep;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout/payment', name: 'checkout_payment')]
class PaymentController extends AbstractCheckoutController
{
    public function __invoke(
        Request $request,
        DeliveryOptionsResolverInterface $optionsResolver,
        PaymentMethodsProviderInterface $paymentMethodProvider
    ): Response {
        $this->getQuoteCalculator()->calculate($this->getCheckoutData());

        if (!$this->getStepMachine()->isStepAllowed($this->getCheckoutData(), PaymentStep::stepIdentifier())) {
            return $this->redirectToCurrentStep();
        }

        $paymentMethods = $paymentMethodProvider->getEligiblePaymentMethods($this->getCheckoutData());

        if ($request->getMethod() === Request::METHOD_POST) {
            $paymentMethod = $paymentMethods[$request->request->getString('payment_method')];
            if ($paymentMethod === null) {
                throw new RuntimeException('Invalid payment method selected');
            }
        }

        return $this->render('commerce/steps/payment.html.twig', [
            'paymentMethods' => $paymentMethods,
            'openTotal' => $this->getCheckoutData()->getOpenTotal(),
            'steps' => $this->getStepsData(),
            'data' => $this->getCheckoutData(),
        ]);
    }
}
