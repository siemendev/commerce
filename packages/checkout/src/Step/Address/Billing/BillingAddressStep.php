<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address\Billing;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
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

    public function validate(CheckoutDataInterface $data): void
    {
        if (!$data instanceof BillingAddressableCheckoutDataInterface) {
            throw new LogicException(sprintf(
                '%s requires %s to implement %s',
                $this::class,
                $data::class,
                BillingAddressableCheckoutDataInterface::class,
            ));
        }

        if (!$data->getBillingAddress()) {
            throw new BillingAddressNotSetException();
        }

        $data->getBillingAddress()?->validate();
    }
}
