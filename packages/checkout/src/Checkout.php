<?php declare(strict_types=1);

namespace Siemendev\Checkout;

use Siemendev\Checkout\Quote\Quote;
use Siemendev\Checkout\Quote\QuoteGeneratorInterface;
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
        private readonly QuoteGeneratorInterface $quoteGenerator,
    ) {
    }

    public function getCurrentStep(CheckoutSessionInterface $session): StepInterface
    {
        return $this->stepMachine->getCurrentStep($session);
    }

    public function getRequiredSteps(CheckoutSessionInterface $session): array
    {
        return $this->stepMachine->getRequiredSteps($session);
    }

    public function isStepAllowed(CheckoutSessionInterface $session, string $stepIdentifier): bool
    {
        // todo something does not work currently, the invalid steps are still displaying a link
        try {
            $this->stepMachine->validateStep($session, $stepIdentifier);
        } catch (AssignedValidationException $exception) {
            return $exception->step::stepIdentifier() === $stepIdentifier;
        }

        return true;
    }

    public function validateStep(CheckoutSessionInterface $session, string $stepIdentifier): void
    {
        $this->stepMachine->validateStep($session, $stepIdentifier);
    }

    public function getQuote(CheckoutSessionInterface $session): Quote
    {
        return $this->quoteGenerator->getQuote($session);
    }
}
