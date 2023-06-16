<?php

declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Commerce\Checkout;
use App\Controller\AbstractCheckoutController;
use Siemendev\Checkout\Delivery\Step\DeliveryAddressStep;
use Siemendev\Checkout\Step\Address\Address;
use Siemendev\Checkout\Step\Address\Billing\BillingAddressStep;
use Siemendev\Checkout\Step\Exception\ValidationException;
use Siemendev\Checkout\Step\StepInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout/address/billing', name: 'checkout_billing_address')]
class BillingAddressController extends AbstractCheckoutController
{
    public function __invoke(Request $request, Checkout $checkout): Response
    {
        $checkout->recalculate();

        if (!$checkout->isStepAllowed(BillingAddressStep::stepIdentifier())) {
            return $this->redirectToCurrentStep();
        }

        /** @var Address $address */
        $address = $checkout->getCheckoutData()->getBillingAddress() ?? new Address();

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

            $checkout->setBillingAddress($address);
            if ($request->request->get('useForDelivery') && $address->isValid()) {
                $checkout->setDeliveryAddress($address);
            }

            try {
                $address->validate();

                return $this->redirectToCurrentStep();
            } catch (ValidationException $e) {
                $message = $e->getMessage();
            }
        }

        return $this->render('commerce/steps/billing_address.html.twig', [
            'delivery_needed' => in_array(DeliveryAddressStep::stepIdentifier(), array_map(fn (StepInterface $step) => $step::stepIdentifier(), $checkout->getRequiredSteps())),
            'message' => $message ?? null,
            'address' => $address,
            'steps' => $this->getStepsData(),
            'data' => $checkout->getCheckoutData(),
        ]);
    }
}
