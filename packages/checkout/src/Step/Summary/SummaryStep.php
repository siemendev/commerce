<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Summary;

use Siemendev\Checkout\CheckoutSessionInterface;
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

    public function validate(CheckoutSessionInterface $session): void
    {
        // summary step is always valid
    }

}
