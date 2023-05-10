<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step;

use Siemendev\Checkout\CheckoutSessionInterface;
use Siemendev\Checkout\Step\Exception\ValidationException;

interface StepInterface
{
    public static function stepIdentifier(): string;

    public static function isRequired(): bool;

    /**
     * @throws ValidationException
     */
    public function validate(CheckoutSessionInterface $session): void;
}
