<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Step\Voter;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Products\Data\ProductCheckoutDataInterface;
use Siemendev\Checkout\Step\StepInterface;
use Siemendev\Checkout\Step\Voter\StepVoterInterface;

class StepVoter implements StepVoterInterface
{
    public function stepRequired(StepInterface $step, CheckoutDataInterface $data): bool
    {
        if (!$data instanceof ProductCheckoutDataInterface) {
            return false;
        }

        foreach ($data->getProducts() as $product) {
            foreach ($product->requiredSteps() as $stepIdentifier) {
                if ($stepIdentifier === $step::stepIdentifier()) {
                    return true;
                }
            }
        }

        return false;
    }
}
