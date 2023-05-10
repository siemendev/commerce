<?php declare(strict_types=1);

namespace App\Controller;

use App\Commerce\CheckoutSession;
use Siemendev\Checkout\Checkout;
use Siemendev\Checkout\CheckoutSessionInterface;
use Siemendev\Checkout\Step\StepInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

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

    public function getCheckoutSession(): CheckoutSession
    {
        $checkoutSession = $this->requestStack->getMainRequest()?->getSession()->get('checkout_session');

        if ($checkoutSession instanceof CheckoutSession) {
            return $checkoutSession;
        }

        return $this->saveCheckoutSession(
            (new CheckoutSession())->setCurrency('EUR')
        );
    }

    public function saveCheckoutSession(CheckoutSessionInterface $checkoutSession): CheckoutSession
    {
        $this->requestStack->getMainRequest()?->getSession()->set('checkout_session', $checkoutSession);

        return $checkoutSession;
    }

    protected function redirectToCurrentStep(): RedirectResponse
    {
        return $this->redirect($this->getCurrentStepUrl());
    }

    protected function getCurrentStepUrl(): string
    {
        return $this->getStepUrl($this->getCheckout()->getCurrentStep($this->getCheckoutSession())::stepIdentifier());
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
                'url' => $this->getCheckout()->isStepAllowed($this->getCheckoutSession(), $step::stepIdentifier()) ? $this->getStepUrl($step::stepIdentifier()) : null
            ],
            $this->getCheckout()->getRequiredSteps($this->getCheckoutSession())
        );
    }
}
