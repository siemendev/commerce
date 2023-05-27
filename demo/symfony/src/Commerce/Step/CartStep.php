<?php declare(strict_types=1);

namespace App\Commerce\Step;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Availability\Exception\AvailabilityProviderNotFoundException;
use Siemendev\Checkout\Products\Data\ProductCheckoutDataInterface;
use Siemendev\Checkout\Products\Step\CartStep as ProductsCartStep;
use Siemendev\Checkout\Step\StepInterface;

/**
 * This is an example how to combine the two cart steps from the products and subscriptions packages into one.
 */
class CartStep implements StepInterface
{
    private ProductsCartStep $productsCartStep;

//    private SubscriptionsCartStep $subscriptionsCartStep;

    public function __construct(
    ) {
        $this->productsCartStep = new ProductsCartStep();
//        $this->subscriptionsCartStep = new SubscriptionsCartStep();
    }

    public static function stepIdentifier(): string
    {
        return 'cart';
    }

    public function isRequired(CheckoutDataInterface $data): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     * @throws AvailabilityProviderNotFoundException
     */
    public function validate(CheckoutDataInterface $data): void
    {
        $this->productsCartStep->validate($data);
//        $this->subscriptionsCartStep->validate($data);
    }

    public function requiresCheckoutData(): array
    {
//        return array_merge(
//            $this->productsCartStep->requiresCheckoutData(),
//            $this->subscriptionsCartStep->requiresCheckoutData(),
//        );

        return $this->productsCartStep->requiresCheckoutData();
    }

    public static function requiresSteps(): array
    {
        return [];
    }
}
