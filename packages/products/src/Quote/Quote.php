<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Quote;

use Siemendev\Checkout\Products\AdditionalCost\AdditionalCostInterface;

class Quote implements QuoteInterface
{
    private string $currency;

    /**
     * @var array<QuoteItemInterface>
     */
    private array $quoteItems = [];

    /**
     * @var array<AdditionalCostInterface>
     */
    private array $additionalCosts = [];

    private int $subTotalNet = 0;

    private int $subTotalGross = 0;

    private int $totalNet = 0;

    private int $totalGross = 0;

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function addQuoteItem(QuoteItemInterface $productQuote): static
    {
        $this->quoteItems[] = $productQuote;
        $this->totalGross += $productQuote->getPrice()->getTotalPriceGross();
        $this->totalNet += $productQuote->getPrice()->getTotalPriceNet();
        $this->subTotalGross += $productQuote->getPrice()->getTotalPriceGross();
        $this->subTotalNet += $productQuote->getPrice()->getTotalPriceNet();

        return $this;
    }

    public function getQuoteItems(): array
    {
        return $this->quoteItems;
    }

    public function addAdditionalCost(AdditionalCostInterface $additionalCost): static
    {
        $this->additionalCosts[] = $additionalCost;
        $this->totalGross += $additionalCost->getAmountGross();
        $this->totalNet += $additionalCost->getAmountNet();

        return $this;
    }

    public function getAdditionalCosts(): array
    {
        return $this->additionalCosts;
    }

    public function getSubTotalNet(): int
    {
        return $this->subTotalNet;
    }

    public function getSubTotalGross(): int
    {
        return $this->subTotalGross;
    }

    public function getTotalNet(): int
    {
        return $this->totalNet;
    }

    public function getTotalGross(): int
    {
        return $this->totalGross;
    }
}
