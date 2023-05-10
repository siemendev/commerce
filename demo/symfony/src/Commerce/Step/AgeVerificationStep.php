<?php declare(strict_types=1);

namespace App\Commerce\Step;

use LogicException;
use Siemendev\Checkout\CheckoutSessionInterface;
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

    public function validate(CheckoutSessionInterface $session): void
    {
        if (!$session instanceof AgeVerifiableCheckoutSessionInterface) {
            throw new LogicException(sprintf(
                '%s requires %s to implement %s',
                $this::class,
                $session::class,
                AgeVerifiableCheckoutSessionInterface::class,
            ));
        }

        if (!$session->isAgeVerified()) {
            throw new AgeNotVerifiedException();
        }
    }
}
