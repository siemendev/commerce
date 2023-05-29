<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Machine;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\Exception\StepNotFoundException;
use Siemendev\Checkout\Step\StepInterface;
use Siemendev\Checkout\Step\Voter\StepVoterInterface;

class RequiredStepsHelper
{
    /**
     * @param array<string, StepInterface> $availableSteps
     */
    private array $availableSteps = [];

    /**
     * @param array<StepInterface> $availableSteps
     * @param array<StepVoterInterface> $stepVoters
     */
    public function __construct(
        array $availableSteps,
        private readonly array $stepVoters = [],
    ) {
        foreach ($availableSteps as $step) {
            $this->availableSteps[$step::stepIdentifier()] = $step;
        }
    }

    /**
     * @return array<StepInterface>
     */
    public function getRequiredSteps(CheckoutDataInterface $data): array
    {
        $stepIdentifiers = [];

        // get all required steps recursively
        foreach ($this->availableSteps as $step) {
            if ($this->isStepRequired($step, $data)) {
                $stepIdentifiers = $this->getRequiredStepsFromStep($step, $stepIdentifiers);
            }
        }

        // check if all required checkout data interfaces are implemented
        foreach ($stepIdentifiers as $step) {
            foreach ($this->availableSteps[$step]->requiresCheckoutData() as $checkoutDataInterface) {
                if (!is_a($data, $checkoutDataInterface)) {
                    throw new LogicException(sprintf('Step "%s" requires checkout data "%s" to implement "%s".', $step::stepIdentifier(), $data::class, $checkoutDataInterface));
                }
            }
        }

        $steps = [];

        foreach ($this->availableSteps as $availableStep) {
            if (in_array($availableStep::stepIdentifier(), $stepIdentifiers, true)) {
                $steps[] = $availableStep;
            }
        }

        return $steps;
    }

    private function isStepRequired(StepInterface $step, CheckoutDataInterface $data): bool
    {
        if ($step->isRequired($data)) {
            return true;
        }
        foreach ($this->stepVoters as $stepVoter) {
            if ($stepVoter->stepRequired($step, $data)) {
                return true;
            }
        }

        return false;
    }

    private function getRequiredStepsFromStep(StepInterface $step, array $stepIdentifiers = []): array
    {
        if (in_array($step::stepIdentifier(), $stepIdentifiers, true)) {
            return $stepIdentifiers;
        }

        $stepIdentifiers[] = $step::stepIdentifier();

        foreach ($step::requiresSteps() as $requiredStep) {
            if (!isset($this->availableSteps[$requiredStep])) {
                throw new StepNotFoundException($requiredStep, $this->availableSteps);
            }
            $stepIdentifiers = $this->getRequiredStepsFromStep($this->availableSteps[$requiredStep], $stepIdentifiers);
        }

        return $stepIdentifiers;
    }
}
