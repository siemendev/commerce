<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Step;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\Exception\ValidationException;

interface StepInterface
{
    public static function stepIdentifier(): string;

    public function isRequired(CheckoutDataInterface $data): bool;

    /**
     * Returns a list of interface names that are required to be implemented in the checkout data.
     *
     * @return array<class-string<CheckoutDataInterface>>
     */
    public function requiresCheckoutData(): array;

    /**
     * Returns a list of steps (step identifiers) that this step depends on.
     *
     * @return array<string>
     */
    public static function requiresSteps(): array;

    /**
     * @throws ValidationException
     */
    public function validate(CheckoutDataInterface $data): void;
}
