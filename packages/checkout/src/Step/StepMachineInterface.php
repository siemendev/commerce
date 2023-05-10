<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step;

use Siemendev\Checkout\CheckoutSessionInterface;
use Siemendev\Checkout\Step\Exception\AssignedValidationException;

interface StepMachineInterface
{
    public function setSteps(array $steps): static;

    /**
     * @throws AssignedValidationException
     */
    public function validate(CheckoutSessionInterface $session): void;

    /**
     * @throws AssignedValidationException
     */
    public function validateStep(CheckoutSessionInterface $session, string $stepIdentifier): void;

    public function getCurrentStep(CheckoutSessionInterface $session): StepInterface;

    public function isStepAllowed(CheckoutSessionInterface $session, string $stepIdentifier): bool;

    /**
     * @return array<StepInterface>
     */
    public function getRequiredSteps(CheckoutSessionInterface $session): array;
}
