<?php declare(strict_types=1);

namespace App\Product;

use Exception;

class ProductNotFoundException extends Exception
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Product with id "%s" not found.', $id));
    }
}
