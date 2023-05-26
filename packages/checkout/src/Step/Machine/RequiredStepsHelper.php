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
        $steps = [];

        // get all required steps recursively
        foreach ($this->availableSteps as $step) {
            if ($this->isStepRequired($step, $data)) {
                $steps = $this->getRequiredStepsFromStep($step, $steps);
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

    private function isStepRequired(StepInterface $step, CheckoutDataInterface $data): bool
    {
        if ($step::isRequired()) {
            return true;
        }
        foreach ($this->stepVoters as $stepVoter) {
            if ($stepVoter->stepRequired($step, $data)) {
                return true;
            }
        }

        return false;
    }

    private function getRequiredStepsFromStep(StepInterface $step, array $steps = []): array
    {
        if (isset($steps[$step::stepIdentifier()])) {
            return $steps;
        }

        $steps[$step::stepIdentifier()] = $step;

        foreach ($step::requiresSteps() as $requiredStep) {
            if (!isset($this->availableSteps[$requiredStep])) {
                throw new StepNotFoundException($requiredStep, $this->availableSteps);
            }
            $steps = $this->getRequiredStepsFromStep($this->availableSteps[$requiredStep], $steps);
        }

        return $steps;
    }
}
