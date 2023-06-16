<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Products\Step;

use LogicException;
use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Data\ProductCheckoutDataInterface;
use Siemendev\Checkout\Step\StepInterface;

class CartStep implements StepInterface
{
    public static function stepIdentifier(): string
    {
        return 'cart';
    }

    public function isRequired(CheckoutDataInterface $data): bool
    {
        return true;
    }

    public function requiresCheckoutData(): array
    {
        return [ProductCheckoutDataInterface::class];
    }

    public function validate(CheckoutDataInterface $data): void
    {
        if (!$data instanceof ProductCheckoutDataInterface) {
            throw new LogicException(sprintf('%s needs to implement %s', $data::class, ProductCheckoutDataInterface::class));
        }

        if (0 === count($data->getProducts())) {
            throw new EmptyCartValidationException();
        }

        // todo check availability
    }

    public static function requiresSteps(): array
    {
        return [];
    }
}
