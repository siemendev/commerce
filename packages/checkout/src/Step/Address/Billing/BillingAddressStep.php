<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address\Billing;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\StepInterface;

class BillingAddressStep implements StepInterface
{
    public static function stepIdentifier(): string
    {
        return 'billing_address';
    }

    public function isRequired(CheckoutDataInterface $data): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @param BillingAddressableCheckoutDataInterface $data
     */
    public function validate(CheckoutDataInterface $data): void
    {
        if (!$data->getBillingAddress()) {
            throw new BillingAddressNotSetException();
        }

        $data->getBillingAddress()->validate();
    }

    public function requiresCheckoutData(): array
    {
        return [BillingAddressableCheckoutDataInterface::class];
    }

    public static function requiresSteps(): array
    {
        return [];
    }
}
