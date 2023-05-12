<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address\Delivery;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
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

    public function validate(CheckoutDataInterface $data): void
    {
        if (!$data instanceof DeliveryAddressableCheckoutDataInterface) {
            throw new LogicException(sprintf(
                '%s requires %s to implement %s',
                $this::class,
                $data::class,
                DeliveryAddressableCheckoutDataInterface::class,
            ));
        }

        if (!$data->getDeliveryAddress()) {
            throw new DeliveryAddressNotSetException();
        }

        $data->getDeliveryAddress()?->validate();
    }
}
