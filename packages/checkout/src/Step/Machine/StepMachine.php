<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Machine;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\Exception\ValidationException;
use Siemendev\Checkout\Step\Exception\AssignedValidationException;
use Siemendev\Checkout\Step\StepInterface;
use Siemendev\Checkout\Step\Summary\SummaryStep;
use Siemendev\Checkout\Step\Voter\StepVoterInterface;

class StepMachine implements StepMachineInterface
{
    /**
     * @param array<StepInterface> $availableSteps
     * @param array<StepVoterInterface> $stepVoters
     */
    public function __construct(
        private array $stepVoters = [],
        private array $availableSteps = [],
    ) {
    }

    /** @param array<StepInterface> $availableSteps */
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

    /** @param array<StepVoterInterface> $stepVoters */
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
            try {
                $step->validate($data);
            } catch (ValidationException $e) {
                throw new AssignedValidationException($e, $step);
            }
        }
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

        return $this->getSummaryStep();
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
        $steps = [];
        foreach ($this->availableSteps as $step) {
            if (in_array($step, $steps, true)) {
                continue;
            }
            if ($step::isRequired()) {
                $steps[] = $step;
                continue;
            }
            foreach ($this->stepVoters as $stepVoter) {
                if ($stepVoter->stepRequired($step, $data)) {
                    $steps[] = $step;
                    continue 2;
                }
            }
        }

        // check if all required checkout data interfaces are implemented
        foreach ($steps as $step) {
            foreach ($step->requiresCheckoutData() as $checkoutDataInterface) {
                if (!is_a($data, $checkoutDataInterface)) {
                    throw new LogicException(sprintf('Step "%s" requires checkout data "%s" to implement "%s".', $step::stepIdentifier(), $data::class, $checkoutDataInterface));
                }
            }
        }

        return $steps;
    }

    // todo the only way to change SummaryStep is to extend it. Make this more flexible by having a FinalStepInterface or something like that
    private function getSummaryStep(): SummaryStep
    {
        foreach ($this->availableSteps as $step) {
            if ($step::stepIdentifier() === SummaryStep::stepIdentifier()) {
                /** @var SummaryStep $step */
                return $step;
            }
        }

        throw new LogicException('No summary step found');
    }
}
