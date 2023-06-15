<?php declare(strict_types=1);

namespace Siemendev\Checkout\Delivery\Step;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Delivery\Data\DeliverableCheckoutDataInterface;
use Siemendev\Checkout\Step\StepInterface;

class DeliveryAddressStep implements StepInterface
{
    public static function stepIdentifier(): string
    {
        return 'delivery_address';
    }

    public function isRequired(CheckoutDataInterface $data): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     * @param DeliverableCheckoutDataInterface $data
     */
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
