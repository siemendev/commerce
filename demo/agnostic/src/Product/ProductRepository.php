<?php

declare(strict_types=1);

namespace Demo\Product;

use Demo\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<Product>
 */
class ProductRepository extends AbstractRepository
{
    public static function getDirectory(): string
    {
        return __DIR__ . '/../../config/products';
    }

    public static function getClass(): string
    {
        return Product::class;
    }
}
