<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\AdditionalCost;

interface AdditionalCostInterface
{
    public function getLabel(): string;

    public function getAmountNet(): int;

    public function getAmountGross(): int;

    public function getCurrency(): string;
}
