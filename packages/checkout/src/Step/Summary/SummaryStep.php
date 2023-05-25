<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Summary;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\FinalStepInterface;
use Siemendev\Checkout\Step\StepInterface;

class SummaryStep implements StepInterface, FinalStepInterface
{
    public static function stepIdentifier(): string
    {
        return 'summary';
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
