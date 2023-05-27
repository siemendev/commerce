<?php declare(strict_types=1);

namespace Siemendev\Checkout\Payment\Step;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Data\ProductCheckoutDataInterface;
use Siemendev\Checkout\Step\StepInterface;

class PaymentStep implements StepInterface
{
    public static function stepIdentifier(): string
    {
        return 'product_payment';
    }

    public function isRequired(CheckoutDataInterface $data): bool
    {
        return false;
    }

    public function requiresCheckoutData(): array
    {
        return [ProductCheckoutDataInterface::class];
    }

    public function validate(CheckoutDataInterface $data): void
    {

    }

    public static function requiresSteps(): array
    {
        return [];
    }
}
