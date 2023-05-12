<?php declare(strict_types=1);

namespace Siemendev\Checkout\Item;

trait RequiredSteps
{
    /** @var array<string> */
    private array $requiresSteps = [];

    public function requiresSteps(): array
    {
        return $this->requiresSteps;
    }

    public function addRequiredStep(string $stepIdentifier): static
    {
        if (!in_array($stepIdentifier, $this->requiresSteps, true)) {
            $this->requiresSteps[] = $stepIdentifier;
        }

        return $this;
    }
}
