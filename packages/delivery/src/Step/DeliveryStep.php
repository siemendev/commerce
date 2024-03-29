<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\Step;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Delivery\Data\DeliverableCheckoutDataInterface;
use Siemendev\Checkout\Step\StepInterface;

class DeliveryStep implements StepInterface
{
    public static function stepIdentifier(): string
    {
        return 'delivery';
    }

    public function isRequired(CheckoutDataInterface $data): bool
    {
        return false;
    }

    public function requiresCheckoutData(): array
    {
        return [DeliverableCheckoutDataInterface::class];
    }

    public function validate(CheckoutDataInterface $data): void
    {
        if (!$data instanceof DeliverableCheckoutDataInterface) {
            throw new LogicException(sprintf('%s needs to implement %s', $data::class, DeliverableCheckoutDataInterface::class));
        }

        if (null === $data->getDeliveryOption()) {
            throw new DeliveryTypeNotSetException($data);
        }
    }

    public static function requiresSteps(): array
    {
        return [DeliveryAddressStep::stepIdentifier()];
    }
}
