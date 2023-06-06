<?php declare(strict_types=1);

namespace App\Controller\Payment;

use App\Commerce\Payment\CreditCardPayment;
use App\Controller\AbstractCheckoutController;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payment/credit-card', name: 'checkout.payment.credit-card')]
class CreditCardPaymentController extends AbstractCheckoutController
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request): Response
    {
        $data = $this->getCheckoutData();

        $openTotal = $data->getOpenTotal();
        $currency = $data->getCurrency();

        // here is where you usually would start by authorizing the credit card payment
        // $externalPaymentId = $externalPaymentProvider->authorize($externalPaymentId, $openTotal);
        $externalPaymentId = (string) rand(100000, 999999); // id mocked for now

        $data
            ->lock() // don't forget to lock the data as soon as you add payments!
            ->getPayments()
            ->add(
                (new CreditCardPayment())
                    ->setIdentifier($externalPaymentId)
                    ->setAmount($openTotal)
                    ->setCurrency($currency)
                    ->authorized()
            )
        ;

        return $this->redirectToCurrentStep();
    }
}
