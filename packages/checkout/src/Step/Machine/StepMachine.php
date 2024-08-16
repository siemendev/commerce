<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Step\Machine;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\Exception\MissingCheckoutDataImplementationException;
use Siemendev\Checkout\Step\Exception\ValidationException;
use Siemendev\Checkout\Step\Exception\AssignedValidationException;
use Siemendev\Checkout\Step\FinalStepInterface;
use Siemendev\Checkout\Step\StepInterface;
use Siemendev\Checkout\Step\Voter\StepVoterInterface;
use LogicException;

class StepMachine implements StepMachineInterface
{
    /**
     * @param array<StepInterface> $availableSteps
     * @param array<StepVoterInterface> $stepVoters
     */
    public function __construct(
        private array $stepVoters = [],
        private array $availableSteps = [],
    ) {}

    /**
     * @param array<StepInterface> $availableSteps
     */
    public function setAvailableSteps(array $availableSteps): static
    {
        $this->availableSteps = $availableSteps;

        return $this;
    }

    /**
     * Use this method with caution, since the order of the steps is important!
     */
    public function addAvailableStep(StepInterface $step): static
    {
        $this->availableSteps[] = $step;

        return $this;
    }

    /**
     * @param array<StepVoterInterface> $stepVoters
     */
    public function setStepVoters(array $stepVoters): static
    {
        $this->stepVoters = $stepVoters;

        return $this;
    }

    public function addStepVoter(StepVoterInterface $stepVoter): static
    {
        $this->stepVoters[] = $stepVoter;

        return $this;
    }

    public function validate(CheckoutDataInterface $data): void
    {
        foreach ($this->getRequiredSteps($data) as $step) {
            foreach ($step->requiresCheckoutData() as $checkoutDataClassName) {
                if (!$data instanceof $checkoutDataClassName) {
                    throw new AssignedValidationException(new MissingCheckoutDataImplementationException($data::class, $checkoutDataClassName, $step::stepIdentifier()), $step);
                }
            }
            try {
                $step->validate($data);
            } catch (ValidationException $e) {
                throw new AssignedValidationException($e, $step);
            }
        }
    }

    public function isValid(CheckoutDataInterface $data): bool
    {
        try {
            $this->validate($data);
        } catch (AssignedValidationException) {
            return false;
        }

        return true;
    }

    public function validateStep(CheckoutDataInterface $checkoutData, string $stepIdentifier): void
    {
        foreach ($this->getRequiredSteps($checkoutData) as $step) {
            try {
                $step->validate($checkoutData);
            } catch (ValidationException $e) {
                throw new AssignedValidationException($e, $step);
            }

            if ($step::stepIdentifier() === $stepIdentifier) {
                return;
            }
        }
    }

    public function getCurrentStep(CheckoutDataInterface $data): StepInterface
    {
        foreach ($this->getRequiredSteps($data) as $step) {
            try {
                $step->validate($data);
            } catch (ValidationException) {
                return $step;
            }
        }

        return $this->getFinalStep();
    }

    public function isStepAllowed(CheckoutDataInterface $data, string $stepIdentifier): bool
    {
        try {
            $this->validateStep($data, $stepIdentifier);
        } catch (AssignedValidationException $exception) {
            return $exception->step::stepIdentifier() === $stepIdentifier;
        }

        return true;
    }

    public function getRequiredSteps(CheckoutDataInterface $data): array
    {
        return (new RequiredStepsHelper($this->availableSteps, $this->stepVoters))->getRequiredSteps($data);
    }

    private function getFinalStep(): FinalStepInterface
    {
        // todo this can be performance optimized by walking the array backwards (final step is usually at the end)
        foreach ($this->availableSteps as $step) {
            if ($step instanceof FinalStepInterface) {
                return $step;
            }
        }

        throw new LogicException('No final step found');
    }
}
