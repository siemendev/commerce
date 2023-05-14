<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\AdditionalCost;

interface QuoteAdditionalCostInterface
{
    public function getLabel(): string;

    public function getAmount(): int;

    public function getCurrency(): string;
}
