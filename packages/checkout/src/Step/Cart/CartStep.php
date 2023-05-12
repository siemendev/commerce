<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Cart;

use Siemendev\Checkout\Availability\AvailabilityProviderNotFoundException;
use Siemendev\Checkout\Availability\AvailabilityResolverInterface;
use Siemendev\Checkout\Availability\Exception\ItemNoLongerAvailableValidationException;
use Siemendev\Checkout\CheckoutSessionInterface;
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
    public function validate(CheckoutSessionInterface $session): void
    {
        if (empty($session->getProducts())) {
            throw new EmptyCartValidationException();
        }

        foreach ($session->getProducts() as $item) {
            if (!$this->availabilityResolver->isAvailable($item)) {
                throw new ItemNoLongerAvailableValidationException($item);
            }
        }
    }
}
