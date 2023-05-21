<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\Exception\AssignedValidationException;

interface StepMachineInterface
{
    /**
     * @throws AssignedValidationException
     */
    public function validate(CheckoutDataInterface $data): void;

    /**
     * @throws AssignedValidationException
     */
    public function validateStep(CheckoutDataInterface $checkoutData, string $stepIdentifier): void;

    public function getCurrentStep(CheckoutDataInterface $data): StepInterface;

    public function isStepAllowed(CheckoutDataInterface $data, string $stepIdentifier): bool;

    /**
     * @return array<StepInterface>
     */
    public function getRequiredSteps(CheckoutDataInterface $data): array;
}
