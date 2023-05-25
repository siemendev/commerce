<?php declare(strict_types=1);

namespace Siemendev\Checkout\Products\Data;


use Siemendev\Checkout\Products\Product\ProductInterface;

trait ContainsProducts
{
    /**
     * @var array<ProductInterface>
     */
    private array $products = [];

    /**
     * @see ProductCheckoutDataInterface::getProducts()
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param array<ProductInterface> $products
     */
    public function setProducts(array $products): static
    {
        $this->products = $products;

        return $this;
    }

    public function addProduct(ProductInterface $product): static
    {
        $this->products[] = $product;

        return $this;
    }

    public function removeProduct(ProductInterface $product): static
    {
        $this->products = array_filter(
            $this->products,
            static fn (ProductInterface $p) => $p !== $product
        );

        return $this;
    }

    public function hasProduct(ProductInterface $product): bool
    {
        return in_array($product, $this->products, true);
    }

    public function clearProducts(): static
    {
        $this->products = [];

        return $this;
    }
}
