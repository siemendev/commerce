<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Step\Machine;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\Exception\AssignedValidationException;
use Siemendev\Checkout\Step\StepInterface;

interface StepMachineInterface
{
    /**
     * @throws AssignedValidationException
     */
    public function validate(CheckoutDataInterface $data): void;

    public function isValid(CheckoutDataInterface $data): bool;

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
