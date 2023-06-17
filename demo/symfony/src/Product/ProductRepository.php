<?php

declare(strict_types=1);

namespace App\Product;

use App\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<Product>
 */
class ProductRepository extends AbstractRepository
{
    public static function getDirectory(): string
    {
        return __DIR__ . '/../../var/products';
    }

    public static function getClass(): string
    {
        return Product::class;
    }
}
