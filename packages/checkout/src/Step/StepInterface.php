<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\Exception\ValidationException;

interface StepInterface
{
    public static function stepIdentifier(): string;

    public static function isRequired(): bool;

    /**
     * Returns a list of interface names that are required to be implemented in the checkout data
     *
     * @return array<class-string>
     */
    public function requiresCheckoutData(): array;

    /**
     * @throws ValidationException
     */
    public function validate(CheckoutDataInterface $data): void;
}
