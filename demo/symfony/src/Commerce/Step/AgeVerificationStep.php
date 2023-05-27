<?php declare(strict_types=1);

namespace App\Commerce\Step;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\StepInterface;

class AgeVerificationStep implements StepInterface
{
    public static function stepIdentifier(): string
    {
        return 'age_verification';
    }

    public function isRequired(CheckoutDataInterface $data): bool
    {
        return false;
    }

    public function validate(CheckoutDataInterface $data): void
    {
        if (!$data instanceof AgeVerifiableCheckoutDataInterface) {
            throw new LogicException(sprintf(
                '%s requires %s to implement %s',
                $this::class,
                $data::class,
                AgeVerifiableCheckoutDataInterface::class,
            ));
        }

        if (!$data->isAgeVerified()) {
            throw new AgeNotVerifiedException();
        }
    }

    public function requiresCheckoutData(): array
    {
        return [AgeVerifiableCheckoutDataInterface::class];
    }

    public static function requiresSteps(): array
    {
        return [];
    }
}
