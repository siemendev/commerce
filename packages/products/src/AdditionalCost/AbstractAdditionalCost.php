<?php

declare(strict_types=1);

namespace Siemendev\Checkout\Products\AdditionalCost;

abstract class AbstractAdditionalCost implements AdditionalCostInterface
{
    public function __construct(
        private readonly int $amountNet,
        private readonly int $amountGross,
    ) {
    }

    public function getAmountGross(): int
    {
        return $this->amountGross;
    }

    public function getAmountNet(): int
    {
        return $this->amountNet;
    }
}
