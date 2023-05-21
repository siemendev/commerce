<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
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

    public function addStep(StepInterface $step): static
    {
        $this->steps[] = $step;

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
        $steps = array_map(
            static fn (StepInterface $step) => $step::stepIdentifier(),
            $this->getRequiredSteps($data),
        );

        if (!in_array($stepIdentifier, $steps, true)) {
            return false;
        }

        $requestedStepIndex = array_search($stepIdentifier, $steps,true);
        $allowedStepIndex = array_search($this->getCurrentStep($data)::stepIdentifier(), $steps, true);

        return $requestedStepIndex <= $allowedStepIndex;
    }

    public function getRequiredSteps(CheckoutDataInterface $data): array
    {
        $requiredCheckoutDataInterfaces = [];

        foreach ($data->getCart()->getItems() as $item) {
            foreach ($item->requiredCheckoutDataInterfaces() as $requiredCheckoutDataInterface) {
                if (in_array($requiredCheckoutDataInterface, $requiredCheckoutDataInterfaces, true)) {
                    continue;
                }
                if (!$data instanceof $requiredCheckoutDataInterface) {
                    throw new LogicException(sprintf('Item "%s" (%s) requires your "%s" to implement "%s" not found', $item->getItemIdentifier(), $item::class, $data::class, $requiredCheckoutDataInterface));
                }
                $requiredCheckoutDataInterfaces[] = $requiredCheckoutDataInterface;
            }
        }

        $steps = [];
        foreach ($this->steps as $step) {
            if (in_array($step, $steps, true)) {
                continue;
            }
            if ($step::isRequired()) {
                $steps[] = $step;
                continue;
            }
            foreach ($step->requiresCheckoutData() as $requiredCheckoutData) {
                if (in_array($requiredCheckoutData, $requiredCheckoutDataInterfaces, true)) {
                    $steps[] = $step;
                    continue 2;
                }
            }
        }

        return $steps;
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
