<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\Exception\ValidationException;

interface StepInterface
{
    public static function stepIdentifier(): string;

    public static function isRequired(): bool;

    /**
     * @throws ValidationException
     */
    public function validate(CheckoutDataInterface $data): void;
}
