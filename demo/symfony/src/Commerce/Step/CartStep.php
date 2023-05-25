<?php declare(strict_types=1);

namespace App\Commerce\Step;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Availability\Exception\AvailabilityProviderNotFoundException;
use Siemendev\Checkout\Products\Data\ProductCheckoutDataInterface;
use Siemendev\Checkout\Step\StepInterface;

class CartStep implements StepInterface
{
    public function __construct(
        // load the cart steps for product and subscription
    ) {
    }

    public static function stepIdentifier(): string
    {
        return 'cart';
    }

    public static function isRequired(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     * @throws AvailabilityProviderNotFoundException
     */
    public function validate(CheckoutDataInterface $data): void
    {
        // combine the two carts for product and subscription
    }

    public function requiresCheckoutData(): array
    {
        return [
            ProductCheckoutDataInterface::class,
//            SubscriptionCheckoutDataInterface::class,
        ];
    }
}
