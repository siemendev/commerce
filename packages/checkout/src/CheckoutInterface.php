<?php declare(strict_types=1);

namespace Siemendev\Checkout;

use Siemendev\Checkout\Quote\Quote;
use Siemendev\Checkout\Step\Exception\AssignedValidationException;
use Siemendev\Checkout\Step\StepInterface;

interface CheckoutInterface
{
    public function getCurrentStep(CheckoutSessionInterface $session): StepInterface;

    public function getRequiredSteps(CheckoutSessionInterface $session): array;

    public function isStepAllowed(CheckoutSessionInterface $session, string $stepIdentifier): bool;

    /**
     * @throws AssignedValidationException
     */
    public function validateStep(CheckoutSessionInterface $session, string $stepIdentifier): void;

    public function getQuote(CheckoutSessionInterface $session): Quote;
}
