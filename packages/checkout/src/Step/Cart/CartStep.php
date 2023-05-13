<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Cart;

use Siemendev\Checkout\Availability\AvailabilityProviderNotFoundException;
use Siemendev\Checkout\Availability\AvailabilityResolverInterface;
use Siemendev\Checkout\Availability\Exception\ItemNoLongerAvailableValidationException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\StepInterface;

class CartStep implements StepInterface
{
    public const STEP_IDENTIFIER = 'cart';

    public function __construct(
        private readonly AvailabilityResolverInterface $availabilityResolver,
    ) {
    }

    public static function stepIdentifier(): string
    {
        return self::STEP_IDENTIFIER;
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
        if ($data->getCart()->isEmpty()) {
            throw new EmptyCartValidationException();
        }

        foreach ($data->getCart()->getItems() as $item) {
            if (!$this->availabilityResolver->isAvailable($item)) {
                throw new ItemNoLongerAvailableValidationException($item);
            }
        }
    }

    public function requiresCheckoutData(): array
    {
        return [CheckoutDataInterface::class];
    }
}
