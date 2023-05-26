<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Address\Delivery;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\Delivery\DeliverableCheckoutDataInterface;
use Siemendev\Checkout\Step\Delivery\DeliveryStep;
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
        if (!$data->getDeliveryAddress()) {
            throw new DeliveryAddressNotSetException();
        }

        $data->getDeliveryAddress()->validate();
    }

    public function requiresCheckoutData(): array
    {
        return [DeliverableCheckoutDataInterface::class];
    }

    public static function requiresSteps(): array
    {
        return [DeliveryStep::stepIdentifier()];
    }
}
