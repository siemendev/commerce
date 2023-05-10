<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address\Delivery;

use LogicException;
use Siemendev\Checkout\CheckoutSessionInterface;
use Siemendev\Checkout\Step\StepInterface;

class DeliveryAddressStep implements StepInterface
{
    public static function stepIdentifier(): string
    {
        return 'delivery_address';
    }

    public static function isRequired(): bool
    {
        return false;
    }

    public function validate(CheckoutSessionInterface $session): void
    {
        if (!$session instanceof DeliveryAddressableCheckoutSessionInterface) {
            throw new LogicException(sprintf(
                '%s requires %s to implement %s',
                $this::class,
                $session::class,
                DeliveryAddressableCheckoutSessionInterface::class,
            ));
        }

        if (!$session->getDeliveryAddress()) {
            throw new DeliveryAddressNotSetException();
        }

        $session->getDeliveryAddress()?->validate();
    }
}
