<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step;

use LogicException;
use Siemendev\Checkout\CheckoutSessionInterface;
use Siemendev\Checkout\Item\ItemInterface;
use Siemendev\Checkout\Step\Exception\PreviousStepValidationException;
use Siemendev\Checkout\Step\Exception\StepNotFoundException;
use Siemendev\Checkout\Step\Exception\ValidationException;
use Siemendev\Checkout\Step\Exception\AssignedValidationException;
use Siemendev\Checkout\Step\Summary\SummaryStep;

class StepMachine implements StepMachineInterface
{
    /** @var array<StepInterface> */
    private array $steps;

    /** @param $steps array<StepInterface>|null */
    public function __construct(?array $steps = null)
    {
        $this->steps = $steps ?? [];
    }

    /** @param $steps array<StepInterface> */
    public function setSteps(array $steps): static
    {
        $this->steps = $steps;

        return $this;
    }

    public function validate(CheckoutSessionInterface $session): void
    {
        foreach ($this->getRequiredSteps($session) as $step) {
            try {
                $step->validate($session);
            } catch (ValidationException $e) {
                throw new AssignedValidationException($e, $step);
            }
        }
    }

    public function validateStep(CheckoutSessionInterface $session, string $stepIdentifier): void
    {
        foreach ($this->getRequiredSteps($session) as $step) {
            try {
                $step->validate($session);
            } catch (ValidationException $e) {
                throw new AssignedValidationException($e, $step);
            }

            if ($step::stepIdentifier() === $stepIdentifier) {
                return;
            }
        }
    }

    public function getCurrentStep(CheckoutSessionInterface $session): StepInterface
    {
        foreach ($this->getRequiredSteps($session) as $step) {
            try {
                $step->validate($session);
            } catch (ValidationException) {
                return $step;
            }
        }

        return $this->getSummaryStep();
    }

    public function isStepAllowed(CheckoutSessionInterface $session, string $stepIdentifier): bool
    {
        $steps = array_map(
            static fn (StepInterface $step) => $step::stepIdentifier(),
            $this->getRequiredSteps($session),
        );

        if (!in_array($stepIdentifier, $steps, true)) {
            return false;
        }

        $requestedStepIndex = array_search($stepIdentifier, $steps,true);
        $allowedStepIndex = array_search($this->getCurrentStep($session)::stepIdentifier(), $steps, true);

        return $requestedStepIndex <= $allowedStepIndex;
    }

    // todo subject for performance optimization
    public function getRequiredSteps(CheckoutSessionInterface $session): array
    {
        // first get all steps that are required by items
        $requiredSteps = array_unique(array_merge(...array_map(
            static fn (ItemInterface $item) => $item->requiresSteps(),
            array_filter(
                $session->getItems(),
                static fn (ItemInterface $item) => !empty($item->requiresSteps())
            )
        )));

        // check if a required step is not in $this->steps
        foreach ($requiredSteps as $requiredStep) {
            if (!in_array($requiredStep, array_map(static fn (StepInterface $step) => $step::stepIdentifier(), $this->steps), true)) {
                throw new LogicException(sprintf('Required step "%s" not found', $requiredStep));
            }
        }

        // then filter out all steps that are not required or which classname is not in $requiredSteps
        return array_values(array_filter(
            $this->steps,
            static fn (StepInterface $step) => $step::isRequired() || in_array($step::stepIdentifier(), $requiredSteps, true)
        ));
    }

    private function getSummaryStep(): SummaryStep
    {
        foreach ($this->steps as $step) {
            if ($step::stepIdentifier() === SummaryStep::stepIdentifier()) {
                return $step;
            }
        }

        throw new LogicException('No summary step found');
    }
}
