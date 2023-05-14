<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote;

use Siemendev\Checkout\Quote\Action\QuoteActionInterface;
use Siemendev\Checkout\Quote\AdditionalCost\QuoteAdditionalCostInterface;
use Siemendev\Checkout\Quote\Trait\WithProducts;
use Siemendev\Checkout\Quote\Trait\WithSubscriptions;

class Quote implements QuoteInterface
{
    use WithProducts;
    use WithSubscriptions;

    /** @var array<QuoteActionInterface> */
    private array $actions = [];

    /** @var array<QuoteAdditionalCostInterface> */
    private array $additionalCosts = [];

    public function getActions(): array
    {
        return $this->actions;
    }

    public function addAction(QuoteActionInterface $action): static
    {
        $this->actions[] = $action;

        return $this;
    }

    public function getAdditionalCosts(): array
    {
        return $this->additionalCosts;
    }

    public function addAdditionalCost(QuoteAdditionalCostInterface $additionalCost): static
    {
        $this->additionalCosts[] = $additionalCost;

        return $this;
    }
}
