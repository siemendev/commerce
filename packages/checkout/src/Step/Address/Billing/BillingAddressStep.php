<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address\Billing;

use LogicException;
use Siemendev\Checkout\CheckoutSessionInterface;
use Siemendev\Checkout\Step\StepInterface;
use Siemendev\Checkout\Step\Exception\ValidationException;

class BillingAddressStep implements StepInterface
{
    public static function stepIdentifier(): string
    {
        return 'billing_address';
    }

    public static function isRequired(): bool
    {
        return true;
    }

    public function validate(CheckoutSessionInterface $session): void
    {
        if (!$session instanceof BillingAddressableCheckoutSessionInterface) {
            throw new LogicException(sprintf(
                '%s requires %s to implement %s',
                $this::class,
                $session::class,
                BillingAddressableCheckoutSessionInterface::class,
            ));
        }

        if (!$session->getBillingAddress()) {
            throw new BillingAddressNotSetException();
        }

        $session->getBillingAddress()?->validate();
    }
}
