<?php

declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Controller\AbstractCheckoutController;
use Demo\Commerce\Checkout;
use Siemendev\Checkout\Delivery\Step\DeliveryAddressStep;
use Siemendev\Checkout\Step\Address\Address;
use Siemendev\Checkout\Step\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout/address/delivery', name: 'checkout_delivery_address')]
class DeliveryAddressController extends AbstractCheckoutController
{
    public function __invoke(Request $request, Checkout $checkout): Response
    {
        $checkout->recalculate();

        if (!$checkout->isStepAllowed(DeliveryAddressStep::stepIdentifier())) {
            return $this->redirectToCurrentStep();
        }

        /** @var Address $address */
        $address = $checkout->getCheckoutData()->getDeliveryAddress() ?? new Address();

        if ('POST' === $request->getMethod()) {
            if ($name = $request->request->get('name')) {
                $address->setName($name);
            }
            if ($addressLine1 = $request->request->get('address_line1')) {
                $address->setAddressLine1($addressLine1);
            }
            if ($addressLine2 = $request->request->get('address_line2')) {
                $address->setAddressLine2($addressLine2);
            }
            if ($postalCode = $request->request->get('postal_code')) {
                $address->setPostalCode($postalCode);
            }
            if ($city = $request->request->get('city')) {
                $address->setCity($city);
            }
            if ($state = $request->request->get('state')) {
                $address->setState($state);
            }
            if ($country = $request->request->get('country')) {
                $address->setCountryCode($country);
            }

            $checkout->setDeliveryAddress($address);

            try {
                $address->validate();

                return $this->redirectToCurrentStep();
            } catch (ValidationException $e) {
                $message = $e->getMessage();
            }
        }

        return $this->render('commerce/steps/delivery_address.html.twig', [
            'message' => $message ?? null,
            'address' => $address,
            'steps' => $this->getStepsData(),
            'data' => $checkout->getCheckoutData(),
        ]);
    }
}
