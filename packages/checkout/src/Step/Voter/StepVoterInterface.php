<?php declare(strict_types=1);

namespace Siemendev\Checkout\Step\Voter;

use Siemendev\Checkout\Data\CheckoutDataInterface;
use Siemendev\Checkout\Step\StepInterface;

interface StepVoterInterface
{
    public function stepRequired(StepInterface $step, CheckoutDataInterface $data): bool;
}
