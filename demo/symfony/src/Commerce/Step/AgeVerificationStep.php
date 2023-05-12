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

    public static function isRequired(): bool
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
}
