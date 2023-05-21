<?php declare(strict_types=1);

namespace App\Controller;

use App\Commerce\CheckoutData;
use Siemendev\Checkout\Checkout;
use Siemendev\Checkout\Step\StepInterface;
use Siemendev\Checkout\SymfonyBridge\Data\CheckoutDataManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * FYI this is the worst possible implementation and should not be viewed as a best practice.
 * Please implement a proper service architecture for handling the checkout data in your application.
 * Why is this bad? -> https://en.wikipedia.org/wiki/Composition_over_inheritance
 */
abstract class AbstractCheckoutController extends AbstractController
{
    public function __construct(
        private readonly Checkout $checkout,
        private readonly CheckoutDataManager $checkoutDataManager,
    ) {
    }

    public function getCheckout(): Checkout
    {
        return $this->checkout;
    }

    public function getCheckoutData(): CheckoutData
    {
        return $this->checkoutDataManager->getCheckoutData();
    }

    public function saveCheckoutData(CheckoutData $checkoutData): CheckoutData
    {
        $this->checkoutDataManager->saveCheckoutData($checkoutData);

        return $checkoutData;
    }

    protected function redirectToCurrentStep(): RedirectResponse
    {
        return $this->redirect($this->getCurrentStepUrl());
    }

    protected function getCurrentStepIdentifier(): string
    {
        return $this->getCheckout()->getCurrentStep($this->getCheckoutData())::stepIdentifier();
    }

    protected function getCurrentStepUrl(): string
    {
        return $this->getStepUrl($this->getCurrentStepIdentifier());
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
