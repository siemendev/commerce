<?php declare(strict_types=1);

namespace App\Controller;

use App\Commerce\CheckoutData;
use Siemendev\Checkout\Checkout;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\StepInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * FYI this is the worst possible implementation and should not be viewed as a best practice.
 * Please implement a proper service architecture for handling the checkout data in your application.
 */
abstract class AbstractCheckoutController extends AbstractController
{
    public function __construct(
        private readonly Checkout $checkout,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function getCheckout(): Checkout
    {
        return $this->checkout;
    }

    public function getCheckoutData(): CheckoutData
    {
        $checkoutData = $this->requestStack->getMainRequest()?->getSession()->get('checkout_data');

        if ($checkoutData instanceof CheckoutData) {
            return $checkoutData;
        }

        return $this->saveCheckoutData(new CheckoutData());
    }

    public function saveCheckoutData(CheckoutDataInterface $checkoutData): CheckoutData
    {
        $this->requestStack->getMainRequest()?->getSession()->set('checkout_data', $checkoutData);

        return $checkoutData;
    }

    protected function redirectToCurrentStep(): RedirectResponse
    {
        return $this->redirect($this->getCurrentStepUrl());
    }

    protected function getCurrentStepUrl(): string
    {
        return $this->getStepUrl($this->getCheckout()->getCurrentStep($this->getCheckoutData())::stepIdentifier());
    }

    protected function getStepUrl(string $stepIdentifier): string
    {
        return $this->generateUrl('checkout_' . $stepIdentifier);
    }

    /**
     * @return array<array{id: string, url: string}>
     */
    protected function getStepsData(): array
    {
        return array_map(
            fn (StepInterface $step): array => [
                'id' => $step::stepIdentifier(),
                'url' => $this->getCheckout()->isStepAllowed($this->getCheckoutData(), $step::stepIdentifier()) ? $this->getStepUrl($step::stepIdentifier()) : null
            ],
            $this->getCheckout()->getRequiredSteps($this->getCheckoutData())
        );
    }
}
