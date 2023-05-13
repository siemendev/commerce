<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Summary;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\StepInterface;

class SummaryStep implements StepInterface
{
    public const STEP_IDENTIFIER = 'summary';

    public static function stepIdentifier(): string
    {
        return self::STEP_IDENTIFIER;
    }

    public static function isRequired(): bool
    {
        return true;
    }

    public function validate(CheckoutDataInterface $data): void
    {
        // summary step is always valid
    }

    public function requiresCheckoutData(): array
    {
        return [CheckoutDataInterface::class];
    }
}
