<?php declare(strict_types=1);

namespace Siemendev\Checkout\Quote\Trait;

use Siemendev\Checkout\Quote\Product\ProductQuoteInterface;

trait WithProducts
{
    /** @var array<ProductQuoteInterface> */
    private array $products = [];
    
    private int $subTotalNet = 0;

    private int $subTotalGross = 0;

    private int $totalNet = 0;

    private int $totalGross = 0;

    public function getProducts(): array
    {
        return $this->products;
    }

    public function addProduct(ProductQuoteInterface $product): static
    {
        $this->products[] = $product;

        return $this;
    }

    public function setSubTotalNet(int $subTotalNet): static
    {
        $this->subTotalNet = $subTotalNet;

        return $this;
    }

    public function getSubTotalNet(): int
    {
        return $this->subTotalNet;
    }

    public function setSubTotalGross(int $subTotalGross): static
    {
        $this->subTotalGross = $subTotalGross;

        return $this;
    }

    public function getSubTotalGross(): int
    {
        return $this->subTotalGross;
    }

    public function setTotalNet(int $totalNet): static
    {
        $this->totalNet = $totalNet;

        return $this;
    }

    public function getTotalNet(): int
    {
        return $this->totalNet;
    }

    public function setTotalGross(int $totalGross): static
    {
        $this->totalGross = $totalGross;

        return $this;
    }

    public function getTotalGross(): int
    {
        return $this->totalGross;
    }
}
