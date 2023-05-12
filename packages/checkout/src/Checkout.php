<?php declare(strict_types=1);

namespace Siemendev\Checkout;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Quote\Quote;
use Siemendev\Checkout\Quote\Builder\QuoteBuilderInterface;
use Siemendev\Checkout\Step\Exception\AssignedValidationException;
use Siemendev\Checkout\Step\StepInterface;
use Siemendev\Checkout\Step\StepMachineInterface;

/**
 * Checkout facade
 * Bundles all checkout related functionality
 */
class Checkout implements CheckoutInterface
{
    public function __construct(
        private readonly StepMachineInterface $stepMachine,
        private readonly QuoteBuilderInterface $quoteBuilder,
    ) {
    }

    public function getCurrentStep(CheckoutDataInterface $data): StepInterface
    {
        return $this->stepMachine->getCurrentStep($data);
    }

    public function getRequiredSteps(CheckoutDataInterface $data): array
    {
        return $this->stepMachine->getRequiredSteps($data);
    }

    public function isStepAllowed(CheckoutDataInterface $data, string $stepIdentifier): bool
    {
        // todo something does not work currently, the invalid steps are still displaying a link
        try {
            $this->stepMachine->validateStep($data, $stepIdentifier);
        } catch (AssignedValidationException $exception) {
            return $exception->step::stepIdentifier() === $stepIdentifier;
        }

        return true;
    }

    public function validateStep(CheckoutDataInterface $data, string $stepIdentifier): void
    {
        $this->stepMachine->validateStep($data, $stepIdentifier);
    }

    public function getQuoteByCheckoutData(CheckoutDataInterface $data): Quote
    {
        return $this->quoteBuilder->getQuoteByCheckoutData($data);
    }
}
