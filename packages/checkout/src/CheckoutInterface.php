<?php declare(strict_types=1);

namespace Siemendev\Checkout;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Quote\Quote;
use Siemendev\Checkout\Step\Exception\AssignedValidationException;
use Siemendev\Checkout\Step\StepInterface;

interface CheckoutInterface
{
    public function getCurrentStep(CheckoutDataInterface $data): StepInterface;

    public function getRequiredSteps(CheckoutDataInterface $data): array;

    public function isStepAllowed(CheckoutDataInterface $data, string $stepIdentifier): bool;

    /**
     * @throws AssignedValidationException
     */
    public function validateStep(CheckoutDataInterface $data, string $stepIdentifier): void;

    public function getQuoteByCheckoutData(CheckoutDataInterface $data): Quote;
}
